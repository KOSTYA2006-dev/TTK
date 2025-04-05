@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $task->title }}</h1>
        <div class="flex space-x-4">
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Редактировать
            </a>
            <a href="{{ route('tasks.history', $task) }}" class="btn btn-secondary">
                <i class="fas fa-history me-2"></i>История изменений
            </a>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Назад к задачам
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Описание задачи</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($task->description)) !!}
                </div>
            </div>

            @if($task->images)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Изображения</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($task->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" alt="Task image" class="w-full h-48 object-cover rounded">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Информация о задаче</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Статус</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($task->status == 'current') bg-blue-100 text-blue-800
                                @elseif($task->status == 'delayed') bg-red-100 text-red-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $task->getStatusNames()[$task->status] }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Приоритет</label>
                        <div class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($task->priority == 'low') bg-green-100 text-green-800
                                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Создана</label>
                        <div class="mt-1">{{ $task->created_at->format('d.m.Y H:i') }}</div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Срок выполнения</label>
                        <div class="mt-1">{{ $task->due_date->format('d.m.Y') }}</div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Создатель</label>
                        <div class="mt-1">{{ $task->user->name }}</div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Ответственный</label>
                        <div class="mt-1">{{ $task->responsible->name }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Изменить статус</h2>
                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <select class="form-select" name="status" required>
                            <option value="current" {{ $task->status == 'current' ? 'selected' : '' }}>Текущая</option>
                            <option value="delayed" {{ $task->status == 'delayed' ? 'selected' : '' }}>Просроченная</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Завершенная</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Обновить статус</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 