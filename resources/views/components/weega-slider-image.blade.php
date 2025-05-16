<figure>
    @if($imageHref)
        <a href="{{$imageHref}}" class="image-link">
            @endif
            <img class="desktop-image" src="{{$desktopImageSrc}}" alt="">
            <img class="mobile-image" src="{{$mobileImageSrc ?? $desktopImageSrc}}" alt="">
            @if($imageHref)
        </a>
    @endif
</figure>
