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
                                {{ $user->full_name }}
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
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

@push('styles')
<style>
.container {
    max-width: 1400px;
    margin: 0 auto;
}

.btn-primary {
    background-color: #e31235;
    border-color: #e31235;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #c0102d;
    border-color: #c0102d;
    transform: translateY(-1px);
}

.form-control, .form-select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #e31235;
    box-shadow: 0 0 0 0.2rem rgba(227, 18, 53, 0.25);
    outline: none;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 768px) {
    .md\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

.bg-white {
    background-color: white;
}

.rounded-lg {
    border-radius: 8px;
}

.shadow {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.p-6 {
    padding: 1.5rem;
}

.mb-6 {
    margin-bottom: 1.5rem;
}

.text-2xl {
    font-size: 1.5rem;
    line-height: 2rem;
}

.font-bold {
    font-weight: 700;
}

.text-lg {
    font-size: 1.125rem;
    line-height: 1.75rem;
}

.font-semibold {
    font-weight: 600;
}

.text-gray-500 {
    color: #6b7280;
}

.text-center {
    text-align: center;
}

.flex {
    display: flex;
}

.justify-between {
    justify-content: space-between;
}

.items-center {
    align-items: center;
}

.justify-end {
    justify-content: flex-end;
}

.gap-4 {
    gap: 1rem;
}

.me-2 {
    margin-right: 0.5rem;
}

.task-card {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.task-card.current {
    border-left: 4px solid #e31235;
}

.task-card.delayed {
    border-left: 4px solid #dc3545;
}

.task-card.completed {
    border-left: 4px solid #28a745;
}

.task-card .task-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.task-card .task-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
    word-wrap: break-word;
}

.task-card .task-description {
    color: #6b7280;
    margin-bottom: 0.5rem;
    word-wrap: break-word;
}

.task-card .task-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
    color: #6b7280;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.task-card .task-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
    flex-wrap: wrap;
}

.task-card .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .task-card .task-image {
        height: 150px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('[data-edit-task]').forEach(button => {
        button.addEventListener('click', async function() {
            const taskId = this.dataset.taskId;
            try {
                const response = await fetch(`/tasks/${taskId}`);
                const task = await response.json();

                document.getElementById('editTaskId').value = task.id;
                document.getElementById('editTitle').value = task.title;
                document.getElementById('editDescription').value = task.description;
                document.getElementById('editResponsibleId').value = task.responsible_id;
                document.getElementById('editPriority').value = task.priority;
                document.getElementById('editDueDate').value = task.due_date;

                const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                modal.show();
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
@endpush
