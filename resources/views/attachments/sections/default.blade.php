@php
    $attachment = $section->sectionable;
@endphp

@if ($attachment)
    <div class="section section-attachment {{ $section->param('class') }}">
        @include('belt-content::sections.sections._heading')
        @include('belt-content::sections.sections._before')
        @include('belt-clip::attachments.web.show')
        @include('belt-content::sections.sections._after')
    </div>
@else
    <p>section with empty attachment</p>
@endif