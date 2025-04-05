<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создание задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Создать задачу</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Удаляем инициализацию TinyMCE
    });
</script>
@endpush 