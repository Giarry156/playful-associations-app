<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss', 'resources/css/welcome.scss', 'resources/css/navbar.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
    <nav>
        <div class="container">
            <h1>Hubsociazioni</h1>
            <x-user-menu :$user/>
        </div>
    </nav>
    <main>
        <div class="container">
            <x-section
                section-id="presidency-section"
                section-title="Sei presidente di"
            >
                <div class="card-container">
                    @foreach ($presidencyAssociations as $association)
                        <x-presidency-card :$association/>
                    @endforeach
                </div>
            </x-section>
            <x-section
                section-id="bind-section"
                section-title="Sei associato a"
            >
                <div class="card-container">
                    @foreach ($bindAssociations as $association)
                        <x-bind-card :$association :$user/>
                    @endforeach
                </div>
            </x-section>
            <x-section
                section-id="games-section"
                section-title="Le tue ultime partite"
            >
                <div class="card-container">
                    @foreach ($games as $game)
                        <x-game-card :$game/>
                    @endforeach
                </div>
            </x-section>
        </div>
    </main>
</body>
</html>
