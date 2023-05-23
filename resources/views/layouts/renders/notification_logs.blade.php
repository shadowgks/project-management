@inject('templateHelper', 'App\Helpers\TemplateHelper')

@foreach ($logs as $log)
    <div class="d-flex flex-stack py-4">
        <div class="d-flex align-items-center me-2">
            <span
                class="w-70px badge badge-light-{{ $templateHelper::getEventColor($log['event']) }} me-4">{{ $log['event'] }}</span>
            <a href="#" class="text-gray-800 text-hover-primary fw-semibold">{{ $log['description'] }}</a>
        </div>
        <span class="badge badge-light fs-8">{{ $log->created_at->diffForHumans() }}</span>
    </div>
@endforeach
