@props([
    'label' => '',
    'value' => '',
    'icon' => 'fa-solid fa-chart-simple',
    'color' => 'primary',
])

@php
    $colorMap = [
        'primary' => 'background: linear-gradient(135deg, #2563eb, #1d4ed8);',
        'info' => 'background: linear-gradient(135deg, #0891b2, #0e7490);',
        'warning' => 'background: linear-gradient(135deg, #f59e0b, #d97706);',
        'success' => 'background: linear-gradient(135deg, #16a34a, #15803d);',
        'danger' => 'background: linear-gradient(135deg, #dc2626, #b91c1c);',
    ];
    $iconStyle = $colorMap[$color] ?? $colorMap['primary'];
@endphp

<div class="stat-card h-100">
    <div class="p-4 d-flex align-items-center">
        <span class="stat-icon text-white me-3" style="{{ $iconStyle }}">
            <i class="{{ $icon }}"></i>
        </span>
        <div class="flex-grow-1">
            <p class="text-muted mb-1 small">{{ $label }}</p>
            <h4 class="mb-0 fw-bold">{{ $value }}</h4>
        </div>
    </div>
</div>
