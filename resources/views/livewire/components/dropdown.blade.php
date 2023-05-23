<div class="dropdown {{ $class }}" {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <button class="btn dropdown-toggle {{ $buttonClass }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $title }}
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach ($data as $dt)
            <a class="dropdown-item" href="{{ $dt['link'] }}">{{ $dt['title'] }}</a>
        @endforeach
    </div>
</div>