{!! $html->description !!}

@if($html->gallery->count())
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">

            @foreach($html->getGallery() as $k => $image)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $k }}" class="{{ !$k ? 'active' : '' }}"></li>
            @endforeach

        </ol>

        <div class="carousel-inner">

            @foreach($html->getGallery() as $k => $image)
                <div class="carousel-item {{ !$k ? 'active' : '' }}">
                    <a href="{{ $image['file'] }}" data-lightbox="roadtrip">
                        <img class="d-block w-100" src="{{ $image['preview'] }}" alt="Slide #{{ ($k + 1) }}" />
                    </a>
                </div>
            @endforeach

        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endif