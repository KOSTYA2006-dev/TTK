<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['user', 'responsible']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('responsible_id')) {
            $query->where('responsible_id', $request->responsible_id);
        }

        $tasks = $query->where('status', 'current')->get();
        $delayedTasks = Task::where('status', 'delayed')->get();
        $completedTasks = Task::where('status', 'completed')->get();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'delayedTasks', 'completedTasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'responsible_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'current';

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('tasks', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }

        $task = Task::create($validated);

        // Записываем историю создания задачи
        $task->histories()->create([
            'user_id' => Auth::id(),
            'event_type' => 'created',
            'changes' => [
                'title' => $task->title,
                'description' => $task->description,
                'responsible_id' => $task->responsible_id,
                'priority' => $task->priority,
                'due_date' => $task->due_date->format('Y-m-d'),
                'status' => $task->status
            ]
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Задача успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['user', 'responsible', 'histories.user']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'responsible_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'removed_images' => 'nullable|array'
        ]);

        $changes = [];
        foreach ($validated as $key => $value) {
            if ($task->$key != $value && $key != 'images' && $key != 'removed_images') {
                $changes[$key] = [
                    'old' => $task->$key,
                    'new' => $value
                ];
            }
        }

        // Обработка удаления изображений
        if ($request->has('removed_images')) {
            foreach ($request->removed_images as $image) {
                Storage::disk('public')->delete($image);
            }
            $currentImages = array_diff($task->images ?? [], $request->removed_images);
            $validated['images'] = $currentImages;
            $changes['images'] = [
                'old' => $task->images,
                'new' => $currentImages
            ];
        }

        // Обработка загрузки новых изображений
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('tasks', 'public');
                $newImages[] = $path;
            }
            $validated['images'] = array_merge($validated['images'] ?? [], $newImages);
            $changes['images'] = [
                'old' => $task->images,
                'new' => $validated['images']
            ];
        }

        $task->update($validated);

        // Записываем историю изменений
        if (!empty($changes)) {
            $task->histories()->create([
                'user_id' => Auth::id(),
                'event_type' => 'updated',
                'changes' => $changes
            ]);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Задача успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Удаляем изображения
        if ($task->images) {
            foreach ($task->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Записываем историю удаления
        $task->histories()->create([
            'user_id' => Auth::id(),
            'event_type' => 'deleted',
            'changes' => [
                'title' => $task->title,
                'description' => $task->description,
                'responsible_id' => $task->responsible_id,
                'priority' => $task->priority,
                'due_date' => $task->due_date->format('Y-m-d'),
                'status' => $task->status
            ]
        ]);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:current,delayed,completed'
        ]);

        $oldStatus = $task->status;
        $task->update($validated);

        // Записываем историю изменения статуса
        $task->histories()->create([
            'user_id' => Auth::id(),
            'event_type' => 'status_changed',
            'changes' => [
                'status' => [
                    'old' => $oldStatus,
                    'new' => $validated['status']
                ]
            ]
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Статус задачи успешно обновлен');
    }

    public function history(Task $task)
    {
        $history = $task->histories()->with('user')->latest()->paginate(10);
        return view('tasks.history', compact('task', 'history'));
    }
}
