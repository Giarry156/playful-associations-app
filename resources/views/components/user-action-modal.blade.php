<div class="user-actions">
    <div class="user-options">
        <div class="user-option">
            <a href="{{url('user_settings')}}">Impostazioni</a>
        </div>
        <div class="user-option">
            <form id="logout-form" method="POST" action={{route('logout')}}>
                @csrf
                <a href="javascript:{}" onclick="document.getElementById('logout-form').submit();"><b>Esci</b></a>
            </form>
        </div>
    </div>
</div>
