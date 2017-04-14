<ul>
    @foreach($album->attachments as $attachment)
        <li><a href="{{ $attachment->secure }}" target="_blank">{{ $attachment->title }}
                @if($attachment->mimetype == 'application/pdf')
                    (PDF)
                @endif
            </a></li>
    @endforeach
</ul>