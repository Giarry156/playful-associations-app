<x-card>
    <h4>{{$game->boardgame->name}}</h4>
    <p>Con {{join(", ", $game->users->map(fn ($u) => $u->name)->toArray())}}</p>
    <p>Il {{$game->created_at->isoFormat('D MMMM YYYY')}}</p>
    <p style="margin-top: 20px; margin-bottom: 0;">Presso <b>{{$game->association->name}}</b></p>
</x-card>
