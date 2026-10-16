@php
    $map = [
        'admin' => ['danger', 'Admin'],
        'merchant' => ['primary', 'Merchant'],
        'customer' => ['secondary', 'Customer'],
    ];
    [$color, $label] = $map[$role] ?? ['light', ucfirst($role)];
@endphp
<span class="badge bg-{{ $color }}-subtle text-{{ $color }}">{{ $label }}</span>
