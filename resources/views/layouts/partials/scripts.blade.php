<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="{{ asset('js/app.js') }}?v={{ @filemtime(public_path('js/app.js')) }}"></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            theme: 'bootstrap-5',
            width: '100%',
            minimumResultsForSearch: 8,
        });
    });
</script>

@if (session('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.showToast(@json(session('toast.message')), @json(session('toast.type')));
        });
    </script>
@endif

@stack('scripts')
