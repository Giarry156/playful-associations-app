<x-form>
    <form id="login-form" action="{{route('login_form')}}" method="GET" class="form">
        @csrf
        <h1 style=" text-align: center">Accedi</h1>
        <x-form-field label="Email" name="email"/>
        <x-form-field label="Password" name="password" type="password"/>
        <button class="form-button" type="submit"><span>Accedi</span></button>
        <p>Non hai un account? <a href="{{url('register')}}">Registrati</a></p>
    </form>
</x-form>
