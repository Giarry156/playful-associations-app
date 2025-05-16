<x-modal
    modal-title="Aggiungi match"
    class-name="add-game-modal"
>
    <div class="form">
        <div class="form-input">
            <span class="form-input-title">Seleziona gioco</span>
            <input type="hidden" name="boardgame_id" id="boardgame_id">
            <div class="form-autocomplete-field">
                <input type="text" name="boardgame_name" id="boardgame_name"
                       placeholder="Nome del gioco">
                <div id="boardgame-autocomplete" class="form-input-autocomplete">
                    @for($i = 0; $i<10; $i++)
                        <div class="form-autocomplete-item" tabindex="0">
                            <span class="autocomplete-item-name">Nome del gioco {{$i}}</span>
                            <span class="autocomplete-item-id">ID: {{$i}}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="form-input">
            <span class="form-input-title">Aggiungi utente</span>
            <input type="hidden" name="user_id" id="user_id">
            <div class="form-autocomplete-field">
                <input class="form-input-text" type="text" name="user_name" id="user_name" placeholder="Nome utente">
                <div id="user-autocomplete" class="form-input-autocomplete">
                    @for($i = 0; $i<10; $i++)
                        <div class="form-autocomplete-item">
                            <span class="autocomplete-item-name">Nome utente: {{$i}}</span>
                            <span class="autocomplete-item-id">ID: {{$i}}</span>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="form-chips-container"></div>
        </div>
    </div>

    <x-slot:actions>
        <button class="modal-button cancel">Annulla</button>
        <button class="unbind-button modal-button confirm">Abbandona</button>
    </x-slot:actions>
</x-modal>

<script>
    const inputAutocompletes = document.querySelectorAll('.form-autocomplete-field input');

    inputAutocompletes.forEach(input => {
        const events = ['keydown', 'focusin', 'input'];
        events.forEach(event => {
            input.addEventListener(event, function () {
                const autocompleteContainer = this.nextElementSibling;
                const value = this.value;

                if (value.length > 0) {
                    autocompleteContainer.classList.add('active');
                    input.classList.add('searching');
                } else {
                    autocompleteContainer.classList.remove('active');
                    input.classList.remove('searching');
                }
            });
        });

        input.addEventListener('focusout', function (e) {
            const autocompleteContainer = input.nextElementSibling;
            console.log(document.activeElement);

            if (document.activeElement !== autocompleteContainer && !autocompleteContainer.contains(document.activeElement)) {
                autocompleteContainer.classList.remove('active');
                input.classList.remove('searching');
            }

        });
    });
</script>
