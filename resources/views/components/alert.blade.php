@if (Session::has('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif
@if (Session::has('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif
