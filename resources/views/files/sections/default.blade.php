@php
    $file = $section->sectionable;
@endphp

<div class="section section-file {{ $section->param('class') }}">
    @include('belt-content::sections.sections._header')
    @include('belt-content::sections.sections._body')
    @include('belt-storage::files.web._show')
    @include('belt-content::sections.sections._footer')
</div>