@php
    $attachment = $attachment ?: new \Belt\Clip\Attachment();
@endphp

@if($attachment->is_image)
    <img class="img-responsive" src="{{ clip($attachment)->src() }}"/>
@endif