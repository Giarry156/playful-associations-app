<x-form>
    <form action="{{route('update_user_settings')}}" method="POST" class="form">
        @csrf
        <h1 style="text-align: center">Impostazioni</h1>
        <x-form-field label="Nome" name="name" defaultValue="{{Auth::user()->toArray()['name'] ?? ''}}"/>
        <x-form-field label="Email" name="email" defaultValue="{{Auth::user()->toArray()['email'] ?? ''}}"/>
        <x-form-field label="Password" type="password" name="password"/>
        <x-form-field label="Conferma Password" type="password" name="password_confirmation"/>
        <button class="form-button" type="submit"><span>Salva</span></button>
    </form>
</x-form>
