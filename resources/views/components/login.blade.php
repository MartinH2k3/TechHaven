<form class="login-form" action="{{ route('login') }}" method="post">
    @csrf
    <h1>Prihlásenie</h1>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" placeholder="Email" required>
    <label for="password">Heslo:</label>
    <input type="password" id="password" name="password" placeholder="Heslo" required>

    <button type="submit" class="login-button">Prihlásiť sa</button>

    <a href="{{ url('admin-login') }}" class="text-button">Prihlásiť sa ako Admin</a>
    <a href="{{ url('register') }}" class="text-button">Registrácia</a>
</form>

