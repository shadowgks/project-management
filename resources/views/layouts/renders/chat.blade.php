@foreach ($messages as $message)
    <div class="d-flex justify-content-{{ $user_id == $message->user_id ? 'end' : 'start' }} mb-10">
        <div class="d-flex flex-column align-items-{{ $user_id == $message->user_id ? 'end' : 'start' }}">
            <div class="d-flex align-items-center mb-2">
                @if ($user_id == $message->user_id)
                    <div class="me-3">
                        <span class="text-muted fs-7 mb-1">{{ $message->created_at->diffForHumans() }}</span>
                        <a
                            class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $message->created_by == null ? '-' : $message->created_by->first_name . ' ' . $message->created_by->last_name }}</a>
                    </div>

                    <div class="symbol  symbol-35px symbol-circle ">
                        <img alt="Pic" src="http://127.0.0.1:8000/demo1/media/avatars/300-25.jpg">
                    </div>
                @else
                    <div class="symbol  symbol-35px symbol-circle ">
                        <img alt="Pic" src="http://127.0.0.1:8000/demo1/media/avatars/300-25.jpg">
                    </div>

                    <div class="ms-3">
                        <a
                            class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $message->created_by == null ? '-' : $message->created_by->first_name . ' ' . $message->created_by->last_name }}</a>
                        <span class="text-muted fs-7 mb-1">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @endif
            </div>

            <div class="p-5 rounded bg-light-{{ $user_id == $message->user_id ? 'primary' : 'info' }} text-dark fw-semibold mw-lg-400px text-start"
                data-kt-element="message-text">
                {{ $message->content }}
            </div>
        </div>
    </div>
@endforeach
