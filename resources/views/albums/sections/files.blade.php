@php
    $album = $section->morphParam('albums');
@endphp

@if ($album)
    <div class="section section-album {{ $section->param('class') }}">
        @include('belt-content::sections.sections._heading')
        @include('belt-content::sections.sections._before')
        @include('belt-clip::albums.web.files')
        @include('belt-content::sections.sections._after')
    </div>
@else
    <p>section with empty album</p>
@endif