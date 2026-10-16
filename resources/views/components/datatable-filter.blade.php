@php
    $fields = $fields ?? [];
@endphp

@if (count($fields) > 0)
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        @foreach ($fields as $field)
            @if ($field['type'] === 'select')
                <div style="width: 200px;">
                    <select class="js-example-basic-multiple form-select" id="{{ $field['id'] }}">
                        @foreach ($field['options'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="input-icon" style="width: 260px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="form-control" id="{{ $field['id'] }}"
                        placeholder="{{ $field['placeholder'] ?? '' }}">
                </div>
            @endif
        @endforeach
    </div>
@endif
