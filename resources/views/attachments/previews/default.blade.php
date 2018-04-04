@php
    $attachment = $section->morphParam('attachments', new \Belt\Clip\Attachment());
@endphp

<div class="row">
    <div class="col-xs-12 col-md-6 col-md-offset-3">
        @include('belt-clip::attachments.previews.thumbnail')
    </div>
</div>