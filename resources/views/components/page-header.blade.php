@props(['title' => '', 'subtitle' => null])

<div class="page-title-box d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1">{{ $title }}</h4>
        @if ($subtitle)
            <p class="text-muted mb-0 small">{{ $subtitle }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="page-title-right mt-2 mt-sm-0">{{ $actions }}</div>
    @endif
</div>
