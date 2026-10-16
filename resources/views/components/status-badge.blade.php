@php
    $map = [
        'pending' => ['warning', 'Menunggu'],
        'confirmed' => ['info', 'Diterima'],
        'preparing' => ['primary', 'Disiapkan'],
        'ready' => ['secondary', 'Siap'],
        'delivered' => ['success', 'Terkirim'],
        'rejected' => ['danger', 'Ditolak'],
        'cancelled' => ['dark', 'Dibatalkan'],
    ];
    [$color, $label] = $map[$status] ?? ['light', $status];
@endphp
<span class="badge bg-{{ $color }}-subtle text-{{ $color }}" style="white-space: nowrap;">{{ $label }}</span>
