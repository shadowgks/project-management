<div {{ $attributes->merge(['class' => 'card shadow-sm ']) }}>
    @if ($hastitle)
    
    <div class="card-header border-0 pt-6">
        {{ $headerContent }}
    </div>
    @endif
    
    <div class="card-body {{ $bodyclass }}" >
        {{ $slot }}
    </div>
    @if ($hasfooter)
    <div class="card-footer">
        {{ $footerContent }}
    </div>
    @endif
</div>