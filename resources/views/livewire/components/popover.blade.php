<span class="popover-back {{ $class }}">
    <i class="fas fa-{{ $icon }}"></i>

    <div class="popover bs-popover-auto m-1 {{ $this->getPosition() }}">
        @if (!empty($title))
            <h3 class="popover-header">{{ $title }}</h3>
        @endif
        <div class="popover-body">{{ $content }}</div>
    </div>
</span>
