<x-form>
    <form method="POST" action="api/users/register">
        @csrf
        <h1 style="text-align: center">Registrati</h1>
        <x-form-field label="Nome" name="name"/>
        <x-form-field label="Email" name="email"/>
        <x-form-field label="Password" type="password" name="password"/>
        <x-form-field label="Conferma Password" type="password" name="password_confirmation"/>
        <button class="form-button register-button" type="submit"><span>Registrati</span></button>
        <p>Non hai un account? <a href="{{url('login')}}">Accedi</a></p>
    </form>
</x-form>
