@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var table = $('#{{ $tableId }}').DataTable({
                serverSide: true,
                searching: false,
                lengthChange: false,
                autoWidth: false,
                pagingType: 'simple',
                dom: 'rt<"d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3"ip>',
                ajax: {
                    url: '{{ $ajaxUrl }}',
                    data: function(d) {
                        @foreach (($filters ?? []) as $key => $value)
                            @php
                                $elementId = is_int($key) ? $value : $key;
                                $paramName = is_int($key) ? $value : $value;
                            @endphp
                            d['{{ $paramName }}'] = document.getElementById('{{ $elementId }}')?.value ?? '';
                        @endforeach
                    },
                },
                columns: @json($columns),
                order: [],
                language: {
                    processing: '<span class="text-muted"><i class="fa-solid fa-spinner fa-spin me-1"></i> Memuat...</span>',
                    emptyTable: 'Tidak ada data.',
                    zeroRecords: 'Tidak ada data yang cocok.',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    paginate: {
                        next: '<span class="d-inline-flex align-items-center">Berikutnya <i class="fa-solid fa-chevron-right ms-1"></i></span>',
                        previous: '<span class="d-inline-flex align-items-center"><i class="fa-solid fa-chevron-left me-1"></i> Sebelumnya</span>',
                    },
                },
            });

            @foreach (($filters ?? []) as $key => $value)
                @php $elementId = is_int($key) ? $value : $key; @endphp
                // Select2 memicu 'change' via jQuery — listener harus pakai jQuery agar tertangkap.
                $('#{{ $elementId }}').on('change', function() {
                    table.ajax.reload();
                });
            @endforeach

            @php
                $filterElementIds = collect($filters ?? [])->map(fn ($v, $k) => is_int($k) ? $v : $k)->all();
            @endphp
            @if (in_array('keyword', $filterElementIds, true))
                var keywordInput = document.getElementById('keyword');
                var debounce;
                keywordInput?.addEventListener('input', function() {
                    clearTimeout(debounce);
                    debounce = setTimeout(function() {
                        table.ajax.reload();
                    }, 400);
                });
            @endif
        });
    </script>
@endpush
