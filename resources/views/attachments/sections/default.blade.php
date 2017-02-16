@php
    $attachment = $section->sectionable;
@endphp

<div class="section section-attachment {{ $section->param('class') }}">
    @include('belt-content::sections.sections._header')
    @include('belt-content::sections.sections._body')
    @include('belt-clip::attachments.web._show')
    @include('belt-content::sections.sections._footer')
</div>