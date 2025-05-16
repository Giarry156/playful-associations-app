<x-modal
    modal-title="Abbandona associazione"
    class-name="unbind-association-modal"
>
    <p>Sei sicuro di voler abbandonare l'associazione <span id="association_name"></span>?</p>

    <x-slot:actions>
        \
        <button class="modal-button cancel">Annulla</button>
        <input type="hidden" name="association_id" id="association_id">
        <button class="unbind-button modal-button confirm">Abbandona</button>
    </x-slot:actions>
</x-modal>
