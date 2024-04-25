@if (Session::has('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif
