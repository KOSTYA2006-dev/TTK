<div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTaskForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Название задачи</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Описание задачи</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="10" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_responsible_id" class="form-label">Ответственный</label>
                        <select class="form-select" id="edit_responsible_id" name="responsible_id" required>
                            <option value="">Выберите ответственного</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_priority" class="form-label">Приоритет</label>
                        <select class="form-select" id="edit_priority" name="priority" required>
                            <option value="low">Низкий</option>
                            <option value="medium">Средний</option>
                            <option value="high">Высокий</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_due_date" class="form-label">Срок выполнения</label>
                        <input type="date" class="form-control" id="edit_due_date" name="due_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_images" class="form-label">Изображения</label>
                        <input type="file" class="form-control" id="edit_images" name="images[]" multiple accept="image/*">
                        <div class="form-text">Можно загрузить несколько изображений</div>
                    </div>

                    <div id="currentImages" class="mb-3">
                        <label class="form-label">Текущие изображения</label>
                        <div class="grid grid-cols-4 gap-4" id="imagesGrid"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editTaskModal = document.getElementById('editTaskModal');
    const editTaskForm = document.getElementById('editTaskForm');
    const imagesGrid = document.getElementById('imagesGrid');

    editTaskModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const taskId = button.getAttribute('data-task-id');
        const task = JSON.parse(button.getAttribute('data-task'));

        editTaskForm.action = `/tasks/${taskId}`;
        document.getElementById('edit_title').value = task.title;
        document.getElementById('edit_description').value = task.description;
        document.getElementById('edit_responsible_id').value = task.responsible_id;
        document.getElementById('edit_priority').value = task.priority;
        document.getElementById('edit_due_date').value = task.due_date;

        // Очищаем и обновляем сетку изображений
        imagesGrid.innerHTML = '';
        if (task.images && task.images.length > 0) {
            task.images.forEach(image => {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="/storage/${image}" alt="Task image" class="w-full h-32 object-cover rounded">
                    <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1" onclick="removeImage('${image}')">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                imagesGrid.appendChild(div);
            });
        }
    });
});

function removeImage(image) {
    if (confirm('Вы уверены, что хотите удалить это изображение?')) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'removed_images[]';
        input.value = image;
        document.getElementById('editTaskForm').appendChild(input);
    }
}
</script>
@endpush 