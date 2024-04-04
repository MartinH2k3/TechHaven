<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
<div class="register-container">
    <form class="register-form" action="{{ route('register') }}" method="POST">
        @csrf
        <h1>Registrácia</h1>
        <label for="first_name">Meno:</label>
        <input type="text" id="first_name" name="first_name" placeholder="Zadaj Meno" required>
        <label for="last_name">Priezvisko:</label>
        <input type="text" id="last_name" name="last_name" placeholder="Zadaj Priezvisko" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Zadaj Email" required>
        <label for="password">Heslo:</label>
        <input type="password" id="password" name="password" placeholder="Zadaj Heslo" required>
        <label for="confirm_password">Potvrď Heslo:</label>
        <input type="password" id="confirm_password" name="password_confirmation" placeholder="Potvrď Heslo" required>

        <fieldset>
            <legend>Pohlavie</legend>
            <label><input type="radio" id="male_checkbox" name="gender" value="male" checked="checked">Muž</label>
            <label><input type="radio" id="female_checkbox" name="gender" value="female">Žena</label>
            <label><input type="radio" id="prefer_not_to_say_checkbox" name="gender" value="other">Iné</label>
        </fieldset>

        <button type="submit" id="register-button">Registrovať sa</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
</body>
</html>
