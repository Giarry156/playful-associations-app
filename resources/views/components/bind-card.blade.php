<x-card
    card-id="bind-card-{{$association->id}}"
>
    <div>
        <h4>{{$association->name}}</h4>
        <p>{{$association->city}}<br>{{$association->address}}</p>
    </div>
    <div class="actions">
        <button class="danger unbind-association-button"
                data-association-id="{{$association->id}}"
                data-association-name="{{$association->name}}"
                @if($association->president_id === $user->id)
                    disabled
            @endif
        >
            Abbandona
        </button>
    </div>
</x-card>
