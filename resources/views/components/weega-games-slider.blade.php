<div id="{{$id}}">
    <div class="games-container-header">
        <div class="games-section-title">
            <h2>{{$sliderTitle}}</h2>
            {{$icon}}
        </div>
        @if($showAllLink && $showAllLink !== '')
            <a class="show-all" href="{{$showAllLink}}">Mostra tutto</a>
        @endif
    </div>
    <section class="showcase">

    </section>
    <section class="games-section">
        <div class="games-section-chevron games-section-chevron-right" data-direction="right">
            <svg width="14" height="27" viewBox="0 0 14 27" fill="none" class="my-auto self-center">
                <path d="M2 24.5L12 13.25L2 2" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </div>
        <div class="games-section-chevron games-section-chevron-left games-section-chevron-hidden"
             data-direction="left">
            <svg width="14" height="27" viewBox="0 0 14 27" fill="none" class="my-auto self-center">
                <path d="M12 2L2 13.25L12 24.5" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </div>
        <div id="games-slider" class="games-container">
            {{$slot}}
        </div>
    </section>
</div>
