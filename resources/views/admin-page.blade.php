<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<header>
    <div class="logout-admin-container">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-admin">Odhlásiť sa</button>
        </form>
    </div>
</header>

<main>
    <div class="admin-container">
        <h1>Admin</h1>
        <a href="{{ route('admin-add') }}" class="button-link">
            <button type="button" class="create-product">Vytvoriť nový produkt</button>
        </a>
        <a href="{{ route('admin-manage') }}" class="button-link">
            <button type="button" class="remove-product">Zmeniť/odstrániť produkt</button>
        </a>
    </div>
</main>

</body>
</html>
