@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">История изменений задачи: {{ $task->title }}</h1>
        <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад к задаче
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse($history as $record)
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">{{ $record->created_at->format('d.m.Y H:i') }}</span>
                                <span class="text-sm font-medium">{{ $record->user->name }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($record->event_type == 'created') bg-green-100 text-green-800
                                    @elseif($record->event_type == 'updated') bg-blue-100 text-blue-800
                                    @elseif($record->event_type == 'deleted') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    @if($record->event_type == 'created')
                                        Создана задача
                                    @elseif($record->event_type == 'updated')
                                        Изменена задача
                                    @elseif($record->event_type == 'deleted')
                                        Удалена задача
                                    @else
                                        Изменен статус
                                    @endif
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changesModal{{ $record->id }}">
                            <i class="fas fa-eye me-2"></i>Просмотреть изменения
                        </button>
                    </div>

                    @if($record->changes)
                        <div class="mt-4">
                            <ul class="list-disc list-inside space-y-2">
                                @foreach($record->changes as $field => $change)
                                    <li>
                                        <span class="font-medium">{{ ucfirst($field) }}:</span>
                                        @if(is_array($change))
                                            @if(isset($change['old']) && isset($change['new']))
                                                <span class="text-red-600 line-through">{{ $change['old'] }}</span>
                                                <span class="text-green-600">→ {{ $change['new'] }}</span>
                                            @else
                                                {{ json_encode($change) }}
                                            @endif
                                        @else
                                            {{ $change }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Modal for detailed changes -->
                <div class="modal fade" id="changesModal{{ $record->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Подробные изменения</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="space-y-4">
                                    @foreach($record->changes as $field => $change)
                                        <div>
                                            <h6 class="font-medium">{{ ucfirst($field) }}</h6>
                                            @if(is_array($change))
                                                @if(isset($change['old']) && isset($change['new']))
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <div class="text-sm text-gray-500">Старое значение</div>
                                                            <div class="p-2 bg-red-50 rounded">{{ $change['old'] }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm text-gray-500">Новое значение</div>
                                                            <div class="p-2 bg-green-50 rounded">{{ $change['new'] }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="p-2 bg-gray-50 rounded">
                                                        {{ json_encode($change) }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="p-2 bg-gray-50 rounded">
                                                    {{ $change }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    Нет записей об изменениях
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $history->links() }}
    </div>
</div>
@endsection 