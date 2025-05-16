<div class="images-slider-container">
    <div class="images-slider">
        <x-weega-slider-image
            desktop-image-src="https://weega.it/_next/image?url=https%3A%2F%2Fweega-production.fra1.digitaloceanspaces.com%2F01JQ8Z1QX7HEQDQ7KHGMXKB2V2.gif&w=1920&q=75"
            mobile-image-src="https://weega.it/_next/image?url=https%3A%2F%2Fweega-production.fra1.digitaloceanspaces.com%2F01JQ8Z1S0HZRYVC8GYA9QDPRFJ.gif&w=750&q=75"
            image-href="https://weega.it/pages/download-app"
        ></x-weega-slider-image>
        <x-weega-slider-image
            desktop-image-src="https://weega-production.fra1.digitaloceanspaces.com/01JV6ZF6DMZ1XVEQSQW3E8BZF1.gif"
            mobile-image-src="https://weega.it/_next/image?url=https%3A%2F%2Fweega-production.fra1.digitaloceanspaces.com%2F01JV6ZF6JY9ME48YF66S8ZE2G0.gif&w=750&q=75"
            image-href="https://weega.it/reega/8291/wondrous-creatures?aff=wga&cmp=sli"
        ></x-weega-slider-image>
        <x-weega-slider-image
            desktop-image-src="https://weega-production.fra1.digitaloceanspaces.com/01JV713ZP8KT3CY7QPD4VDVTVS.gif"
            mobile-image-src="https://weega.it/_next/image?url=https%3A%2F%2Fweega-production.fra1.digitaloceanspaces.com%2F01JV713ZSS3VE95YDMNPZJKXCS.gif&w=750&q=75"
            image-href="https://weega.it/ga/7873/primal-the-awakening?aff=wga&cmp=sli"
        ></x-weega-slider-image>
        <x-weega-slider-image
            desktop-image-src="https://weega-production.fra1.digitaloceanspaces.com/01JV6ZFZ6GNB4QDH3CQPS4WN17.gif"
            mobile-image-src="https://weega.it/_next/image?url=https%3A%2F%2Fweega-production.fra1.digitaloceanspaces.com%2F01JV6ZFZAM945X8W6GVQFB1TSJ.gif&w=750&q=75"
            image-href="https://weega.it/reega/8275/tiny-epic-dungeons?aff=wga&cmp=sli"
        ></x-weega-slider-image>
        <div class="image-selectors">
            @for($index = 0; $index < 4; $index++)
                <div id="image-selector-{{$index}}" class="image-selector" data-index="{{$index}}"></div>
            @endfor
        </div>
        <div class="image-loading-bar"></div>
        <div class="chevron right-chevron" data-orientation="right">
            <svg width="14" height="27" viewBox="0 0 14 27" fill="none" class="my-auto self-center">
                <path d="M2 24.5L12 13.25L2 2" stroke-width="4" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </div>
        <div class="chevron left-chevron" data-orientation="left">
            <svg width="14" height="27" viewBox="0 0 14 27" fill="none" class="my-auto self-center">
                <path d="M12 2L2 13.25L12 24.5" stroke-width="4" stroke-linecap="round"
                      stroke-linejoin="round"></path>
            </svg>
        </div>
    </div>
</div>

<script>
    const imageSliderContainer = document.querySelector('.images-slider-container');
    const imageSlider = document.querySelector('.images-slider');
    const imageSelectors = document.querySelectorAll('.image-selector');
    const loadingBar = document.querySelector('.image-loading-bar');
    const imageSliderChevrons = document.querySelectorAll('.chevron');
    const timeStep = 100;

    let imageSliderMouseOver = false;

    imageSliderContainer.addEventListener('mouseover', () => {
        clearInterval(interval);
    });

    imageSliderContainer.addEventListener('mouseout', () => {
        interval = window.setInterval(updateLoadingBar, timeStep);
    });

    function scrollSlider(index) {
        return () => {
            const scrollTo = imageSlider.clientWidth * index;

            imageSelectors.forEach(selector => {
                if (index !== selector.dataset.index) {
                    selector.classList.remove('active');
                }
            });

            loadingBar.style.width = '0%';

            const selector = document.querySelector(`#image-selector-${index}`);
            selector.classList.add('active');

            imageSlider.scrollTo({
                left: scrollTo,
                behavior: 'smooth'
            });
        }
    }

    function updateLoadingBar() {
        const currentPercentage = parseFloat(loadingBar.style.width) || 0;
        const futurePercentage = currentPercentage + 1;

        if (futurePercentage >= 100) {
            loadingBar.style.width = '0%';

            const activeSelector = document.querySelector('.image-selector.active');
            const nextSelector = activeSelector.nextElementSibling || imageSelectors[0];
            const nextIndex = nextSelector.dataset.index;
            scrollSlider(nextIndex)();

            return;
        }

        loadingBar.style.width = `${futurePercentage}%`;
    }

    let interval = setInterval(updateLoadingBar, timeStep);

    imageSelectors[0].classList.add('active');

    imageSliderChevrons.forEach(chevron => {
        chevron.addEventListener('click', () => {
            const direction = chevron.dataset.orientation;
            const activeSelector = document.querySelector('.image-selector.active');
            const currentIndex = parseInt(activeSelector.dataset.index);
            let nextIndex;

            if (direction === 'right') {
                nextIndex = (currentIndex + 1) % imageSelectors.length;
            } else {
                nextIndex = (currentIndex - 1 + imageSelectors.length) % imageSelectors.length;
            }

            scrollSlider(nextIndex)();
        });
    });

    for (const selector of imageSelectors) {
        selector.addEventListener('click', scrollSlider(selector.dataset.index));
    }
</script>
