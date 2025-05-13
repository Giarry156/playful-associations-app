<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'boardgame_id',
        'association_id',
    ];

    public function boardgame()
    {
        return $this->belongsTo(Boardgame::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_user');
    }

    public static function getTopBoardgamePlayed(): Boardgame
    {
        return Boardgame::withCount('games')
            ->orderBy('games_count', 'desc')
            ->first();
    }

    public static function getTopBoardgamePlayedByAssociations(): Collection
    {
        $games = Game::query()
            ->select('association_id', 'boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('association_id', 'boardgame_id')
            ->with(['association', 'boardgame'])
            ->get();

        return $games
            ->groupBy('association_id')
            ->map(fn($rows) => $rows->sortByDesc('games_count')->first())
            ->values()
            ->map(function ($item) {
                return (object)[
                    'association' => $item->association,
                    'boardgame' => $item->boardgame,
                    'games_count' => $item->games_count,
                ];
            });
    }

    public static function getTopBoardgamePlayedByUsers(): Collection
    {
        // Retrieving all games grouped by user and boardgame.
        $games = Game::query()
            ->join('game_user', 'games.id', '=', 'game_user.game_id')
            ->select('game_user.user_id', 'games.boardgame_id', DB::raw('count(*) as games_count'))
            ->groupBy('game_user.user_id', 'games.boardgame_id')
            ->get();

        // Grouping games by user and taking the top game for each user.
        $topsPerUser = $games
            ->groupBy('user_id')
            ->map(fn($rows) => $rows->sortByDesc('games_count')->first())
            ->values();

        // Retrieving users and boardgames.
        $usersIds = $topsPerUser->pluck('user_id')->unique();
        $boardgamesIds = $topsPerUser->pluck('boardgame_id')->unique();

        $users = User::whereIn('id', $usersIds)->get()->keyBy('id');
        $boardgames = Boardgame::whereIn('id', $boardgamesIds)->get()->keyBy('id');

        // Mapping collection.
        $items = $topsPerUser->map(function ($item) use ($users, $boardgames) {
            return (object)[
                'user' => $users[$item->user_id],
                'boardgame' => $boardgames[$item->boardgame_id],
                'games_count' => $item->games_count,
            ];
        });

        // Returning collection.
        return $items;
    }

    public static function getAveragePerYear(Carbon $year = null): int
    {
        $year = $year ?? Carbon::now();

        return round(Game::query()
                ->whereYear('created_at', $year->year)
                ->count() / User::whereHas('games', function ($query) use ($year) {
                $query->whereYear('games.created_at', $year->year);
            })->count());
    }

    public static function getYearCountPerMonth(Carbon $year = null): array
    {
        $year = $year ?? Carbon::now();

        return Game::query()
            ->whereYear('created_at', $year->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count')
            ->toArray();
    }

    public static function getMonthCount(Carbon $month = null): int
    {
        $month = $month ?? Carbon::now();

        return Game::query()
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->count();
    }
}
