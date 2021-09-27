<ul class="list-unstyled">
    @foreach ($notes as $note)
        <li class="media mb-3" id="note-{{ $note->id }}">
            <div class="media-body">
                <h6 class="mt-0 mb-1">{{ ucwords($note->user->name) }} 
                    <span class="pull-right font-italic font-weight-light"><small> {{ $note->created_at->diffForHumans() }} </small>
                        @if($user->cans('edit_job_applications'))
                            <a href="javascript:;" class="edit-note" data-note-id="{{ $note->id }}"><i class="fa fa-edit ml-2"></i></a>
                            <a href="javascript:;" class="delete-note" data-note-id="{{ $note->id }}"><i class="fa fa-trash ml-1 text-danger"></i></a>
                        @endif
                    </span>
                </h6>
                <small class="note-text">{{ ucfirst($note->note_text) }}</small>
                <div class="note-textarea"></div>
            </div>
        </li>
    @endforeach
</ul>