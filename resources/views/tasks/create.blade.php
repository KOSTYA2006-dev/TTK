@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Создание задачи</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад к задачам
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Название задачи</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание задачи</label>
                <textarea class="form-control" id="description" name="description" rows="10" required></textarea>
            </div>

            <div class="mb-3">
                <label for="responsible_id" class="form-label">Ответственный</label>
                <select class="form-select" id="responsible_id" name="responsible_id" required>
                    <option value="">Выберите ответственного</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Приоритет</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="low">Низкий</option>
                    <option value="medium" selected>Средний</option>
                    <option value="high">Высокий</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Срок выполнения</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Изображения</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                <div class="form-text">Можно загрузить несколько изображений</div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Создать задачу</button>
            </div>
        </form>
    </div>
</div>
@endsection 