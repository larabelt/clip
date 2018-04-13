@php
    $can['albums'] = $auth->can(['create','update','delete'], Belt\Clip\Album::class);
    $can['attachments'] = $auth->can(['create','update','delete'], Belt\Clip\Attachment::class);
@endphp

@if($can['albums'] || $can['attachments'])
    <li id="clip-admin-sidebar-left" class="treeview">
        <a href="#">
            <i class="fa fa-paperclip"></i> <span>Media</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($can['albums'])
                <li id="clip-admin-sidebar-left-albums"><a href="/admin/belt/clip/albums"><i class="fa fa-files-o"></i> <span>Albums</span></a></li>
            @endif
            @if($can['attachments'])
                <li id="clip-admin-sidebar-left-attachments"><a href="/admin/belt/clip/attachments"><i class="fa fa-file-o"></i> <span>Attachments</span></a></li>
            @endif
        </ul>
    </li>
@endif