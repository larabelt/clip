<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        @foreach($album->attachments as $attachment)
            @if($attachment->isImage)
                <img class="img-responsive center-attachment" src="{{ $attachment->src }}"/>
            @endif
        @endforeach
    </div>
</div>