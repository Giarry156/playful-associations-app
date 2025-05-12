<div class="modal hidden" id="{{$modalId}}">
    <div class="modal-content">
        <form id="game-modal" action="{{route('create_game')}}" method="POST" class="form">
            @csrf
            <h1 style=" text-align: center">Crea una partita</h1>
            <input type="hidden" name="association_id" value="{{$associationId}}">
            <input type="hidden" name="boardgame_id" value="{{$boardgameId}}">
            <x-form-field label="Seleziona gioco" name="boardgame" required/>
            <x-form-field label="Aggiungi utente" name="user" required/>
            <button class="form-button" type="submit"><span>Crea</span></button>
        </form>
    </div>
</div>
