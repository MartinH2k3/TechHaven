<div class="stage-content shopping-cart-container">
    <form class="address-form" action="{{ route('cart.address.submit') }}" method="POST" >
        @csrf
        <h1>Dodacie údaje</h1>
        <label for="first_name">Meno:</label>
        <input type="text" id="first_name" name="first_name" placeholder="Zadaj Meno" required>
        <label for="last_name">Priezvisko:</label>
        <input type="text" id="last_name" name="last_name" placeholder="Zadaj Priezvisko" required>
        <label for="street_address">Ulica:</label>
        <input type="text" id="street_address" name="street_address" placeholder="Číslo Ulice" required>
        <label for="street_number">Ulica:</label>
        <input type="text" id="street_number" name="street_number" placeholder="Zadaj Číslo Ulice" required>
        <label for="city">Mesto:</label>
        <input type="text" id="city" name="city" placeholder="Zadaj Mesto" required>
        <label for="postal_code">PSČ:</label>
        <input type="text" id="postal_code" name="postal_code" placeholder="Zadaj PSČ" required>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Zadaj Email" required>
        <label for="phone_number">Telefónne číslo:</label>
        <input type="text" id="phone_number" name="phone_number" placeholder="Zadaj Telefónne číslo" required>

        <button type="submit" id="address-button">Uložiť</button>
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
