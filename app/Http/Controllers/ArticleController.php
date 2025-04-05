<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ArticleException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::with(['user', 'histories' => function($query) {
                $query->latest()->limit(1);
            }])
                ->latest()
                ->paginate(12);

            return view('articles.index', compact('articles'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при загрузке статей');
        }
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:articles,title',
                'content' => 'required|string',
                'image' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('articles', 'public');
            }

            $article = Auth::user()->articles()->create($validated);
            $this->recordHistory($article, 'created');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Статья успешно создана'
                ]);
            }

            return redirect()->route('articles.index')->with('success', 'Статья успешно создана');
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при создании статьи'
                ], 500);
            }
            return back()->with('error', 'Произошла ошибка при создании статьи');
        }
    }

    public function show(Article $article)
    {
        try {
            if (request()->wantsJson()) {
                return response()->json($article);
            }
            return view('articles.show', compact('article'));
        } catch (ModelNotFoundException $e) {
            Log::error('Article not found: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Статья не найдена'
                ], 404);
            }
            return back()->with('error', 'Статья не найдена');
        } catch (\Exception $e) {
            Log::error('Error showing article: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при загрузке статьи');
        }
    }

    public function edit(Article $article)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login.form')->with('error', 'Пожалуйста, авторизуйтесь');
            }

            return view('articles.edit', compact('article'));
        } catch (\Exception $e) {
            Log::error('Error editing article: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при загрузке статьи для редактирования');
        }
    }

    public function update(Request $request, Article $article)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:articles,title,' . $article->id,
                'content' => 'required|string',
                'image' => 'nullable|image|max:2048'
            ]);

            $oldData = $article->toArray();

            if ($request->hasFile('image')) {
                if ($article->image) {
                    Storage::disk('public')->delete($article->image);
                }
                $validated['image'] = $request->file('image')->store('articles', 'public');
            }

            $article->update($validated);
            $this->recordHistory($article, 'updated', $oldData);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Статья успешно обновлена'
                ]);
            }

            return redirect()->route('articles.index')->with('success', 'Статья успешно обновлена');
        } catch (ModelNotFoundException $e) {
            Log::error('Article not found: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Статья не найдена'
                ], 404);
            }
            return back()->with('error', 'Статья не найдена');
        } catch (\Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при обновлении статьи'
                ], 500);
            }
            return back()->with('error', 'Произошла ошибка при обновлении статьи');
        }
    }

    public function destroy(Article $article)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login.form')->with('error', 'Пожалуйста, авторизуйтесь');
            }

            $article->delete();
            $this->recordHistory($article, 'deleted');

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Статья успешно удалена'
                ]);
            }

            return redirect()->route('articles.index')->with('success', 'Статья успешно удалена');
        } catch (ModelNotFoundException $e) {
            Log::error('Article not found: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Статья не найдена'
                ], 404);
            }
            return back()->with('error', 'Статья не найдена');
        } catch (\Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при удалении статьи'
                ], 500);
            }
            return back()->with('error', 'Произошла ошибка при удалении статьи');
        }
    }

    public function history()
    {
        try {
            $histories = ArticleHistory::with(['article' => function($query) {
                $query->withTrashed();
            }, 'user'])
                ->latest()
                ->paginate(10);

            return view('articles.history', compact('histories'));
        } catch (\Exception $e) {
            Log::error('Error fetching article history: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при загрузке истории изменений');
        }
    }

    public function restore($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login.form')->with('error', 'Пожалуйста, авторизуйтесь');
            }

            $article = Article::withTrashed()->findOrFail($id);

            if (!$article->trashed()) {
                throw new ArticleException('Статья не была удалена');
            }

            $article->restore();
            $this->recordHistory($article, 'restored');

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Статья успешно восстановлена'
                ]);
            }

            return redirect()->route('articles.index')->with('success', 'Статья успешно восстановлена');
        } catch (ModelNotFoundException $e) {
            Log::error('Article not found: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Статья не найдена'
                ], 404);
            }
            return back()->with('error', 'Статья не найдена');
        } catch (ArticleException $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 403);
            }
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error restoring article: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при восстановлении статьи'
                ], 500);
            }
            return back()->with('error', 'Произошла ошибка при восстановлении статьи');
        }
    }

    protected function recordHistory($article, $eventType, $oldData = null)
    {
        try {
            ArticleHistory::create([
                'article_id' => $article->id,
                'user_id' => Auth::id(),
                'event_type' => $eventType,
                'old_data' => $oldData,
                'new_data' => $eventType === 'deleted' ? null : $article->fresh()->toArray()
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording article history: ' . $e->getMessage());
        }
    }
}
