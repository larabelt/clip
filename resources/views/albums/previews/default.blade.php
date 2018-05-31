@php
    $album = $section->morphParam('albums', new \Belt\Clip\Album());
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div><h3>{{ $album->name }}</h3></div>
        </div>
        <div class="col-md-7 col-md-offset-1">
            <div class="row tile-panels">
                @foreach($album->attachments->slice(0, 3) as $attachment)
                    <div class="col col-lg-2 col-md-3 col-sm-4">
                        @include('belt-clip::attachments.previews.thumbnail')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>