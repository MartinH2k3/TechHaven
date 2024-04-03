@if (auth()->check())
    <form class="login-form" action="{{ route('logout') }}" method="POST" >
        @csrf
        <button type="submit" class="login-button">Odhlásiť sa</button>
    </form>
@else
<form class="login-form" action="{{ route('login') }}" method="POST">
    @csrf
    <h1>Prihlásenie</h1>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Email" required>
    <label for="password">Heslo:</label>
    <input type="password" id="password" name="password" placeholder="Heslo" required>

    <button type="submit" class="login-button">Prihlásiť sa</button>

    <a href="{{ url('register') }}" class="text-button">Registrácia</a>
    <div class="login-note">*Admini budú presmerovaní</div>
</form>
@endif
