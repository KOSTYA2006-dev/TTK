<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-lg font-semibold">
                <a href="{{ route('tasks.show', $task) }}" class="text-primary hover:text-primary-dark">
                    {{ $task->title }}
                </a>
            </h3>
            <div class="flex items-center space-x-2 mt-1">
                <span class="text-sm text-gray-500">{{ $task->created_at->format('d.m.Y') }}</span>
                <span class="text-sm text-gray-500">•</span>
                <span class="text-sm text-gray-500">{{ $task->responsible->full_name }}</span>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-2 py-1 text-xs font-medium rounded-full
                @if($task->priority == 'low') bg-green-100 text-green-800
                @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst($task->priority) }}
            </span>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('tasks.show', $task) }}">
                            <i class="fas fa-eye me-2"></i>Просмотреть
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('tasks.edit', $task) }}">
                            <i class="fas fa-edit me-2"></i>Редактировать
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('tasks.history', $task) }}">
                            <i class="fas fa-history me-2"></i>История изменений
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Вы уверены, что хотите удалить эту задачу?')">
                                <i class="fas fa-trash me-2"></i>Удалить
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <p class="text-gray-600 line-clamp-2">{{ Str::limit($task->description, 100) }}</p>
    </div>

    <div class="flex justify-between items-center">
        <div>
            <span class="text-sm text-gray-500">Срок: {{ $task->due_date->format('d.m.Y') }}</span>
        </div>
        <div>
            <span class="px-2 py-1 text-xs font-medium rounded-full
                @if($task->status == 'current') bg-blue-100 text-blue-800
                @elseif($task->status == 'delayed') bg-red-100 text-red-800
                @else bg-green-100 text-green-800 @endif">
                {{ $task->getStatusNames()[$task->status] }}
            </span>
        </div>
    </div>

    @if($task->images)
        <div class="mt-3" style="margin-top: 20px">
            <div class="flex space-x-2">
                @foreach($task->images as $image)
                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $image) }}" alt="Task image" class=" object-cover rounded" style="width: 300px">
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
