@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Редактирование задачи</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад к задачам
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Название задачи</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание задачи</label>
                <textarea class="form-control" id="description" name="description" rows="10" required>{{ $task->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="responsible_id" class="form-label">Ответственный</label>
                <select class="form-select" id="responsible_id" name="responsible_id" required>
                    <option value="">Выберите ответственного</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->responsible_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Приоритет</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Низкий</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Средний</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Высокий</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Срок выполнения</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Изображения</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                <div class="form-text">Можно загрузить несколько изображений</div>
            </div>

            @if($task->images)
                <div class="mb-3">
                    <label class="form-label">Текущие изображения</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($task->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" alt="Task image" class="w-full h-32 object-cover rounded">
                                <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1" onclick="removeImage('{{ $image }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function removeImage(image) {
    if (confirm('Вы уверены, что хотите удалить это изображение?')) {
        // Здесь можно добавить AJAX-запрос для удаления изображения
        // или добавить скрытое поле с именем удаляемого изображения
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_images[]';
        input.value = image;
        document.querySelector('form').appendChild(input);
    }
}
</script>
@endpush
@endsection 