@props([
    'name',
    'id' => null,
    'selected' => null,
    'placeholder' => null,
    'options' => [],
])

@php
    $selectId = $id ?? $name;
    $current = old($name, $selected);
    $hasError = isset($errors) && $errors->has($name);
@endphp

<select
    id="{{ $selectId }}"
    name="{{ $name }}"
    class="js-example-basic-multiple form-select @if($hasError) is-invalid @endif"
>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @selected((string) $current === (string) $value)>{{ $label }}</option>
    @endforeach

    {{ $slot ?? '' }}
</select>
