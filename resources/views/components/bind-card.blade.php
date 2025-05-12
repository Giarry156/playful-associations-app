<x-card>
    <h4>{{$association->name}}</h4>
    <p>{{$association->city}}<br>{{$association->address}}</p>
    <div class="actions">
        <button class="danger"
                @if($association->president_id === $user->id)
                    disabled
            @endif
        >Abbandona
        </button>
    </div>
</x-card>
