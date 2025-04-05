@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Задачи</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="fas fa-plus me-2"></i>Создать задачу
        </button>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form action="{{ route('tasks.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="form-label">Поиск</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Поиск по названию...">
                </div>
                <div>
                    <label for="status" class="form-label">Статус</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Все статусы</option>
                        <option value="current" {{ request('status') == 'current' ? 'selected' : '' }}>Текущие</option>
                        <option value="delayed" {{ request('status') == 'delayed' ? 'selected' : '' }}>Просроченные</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершенные</option>
                    </select>
                </div>
                <div>
                    <label for="responsible_id" class="form-label">Ответственный</label>
                    <select class="form-select" id="responsible_id" name="responsible_id">
                        <option value="">Все ответственные</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('responsible_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Поиск</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold">Текущие задачи ({{ $tasks->count() }})</h2>
            @forelse($tasks as $task)
                @include('tasks.partials.task-card', ['task' => $task])
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Нет текущих задач
                </div>
            @endforelse
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold">Просроченные задачи ({{ $delayedTasks->count() }})</h2>
            @forelse($delayedTasks as $task)
                @include('tasks.partials.task-card', ['task' => $task])
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Нет просроченных задач
                </div>
            @endforelse
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-semibold">Завершенные задачи ({{ $completedTasks->count() }})</h2>
            @forelse($completedTasks as $task)
                @include('tasks.partials.task-card', ['task' => $task])
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Нет завершенных задач
                </div>
            @endforelse
        </div>
    </div>
</div>

@include('tasks.modals.create')
@include('tasks.modals.edit')

@endsection

@push('scripts')
<script>
    // Обработка редактирования задачи
    document.querySelectorAll('[data-edit-task]').forEach(button => {
        button.addEventListener('click', async function() {
            const taskId = this.dataset.taskId;
            try {
                const response = await fetch(`/tasks/${taskId}`);
                const task = await response.json();
                
                // Заполняем форму редактирования
                document.getElementById('editTaskId').value = task.id;
                document.getElementById('editTitle').value = task.title;
                document.getElementById('editDescription').value = task.description;
                document.getElementById('editResponsibleId').value = task.responsible_id;
                document.getElementById('editPriority').value = task.priority;
                document.getElementById('editDueDate').value = task.due_date;
                
                // Показываем модальное окно
                const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                modal.show();
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
@endpush 