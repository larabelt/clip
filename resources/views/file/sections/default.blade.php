@php
    $file = $section->sectionable;
@endphp

<div class="section section-file {{ $section->param('class') }}">
    @include('ohio-content::section.sections._header')
    @include('ohio-content::section.sections._body')
    @include('ohio-storage::file.web._show')
    @include('ohio-content::section.sections._footer')
</div>