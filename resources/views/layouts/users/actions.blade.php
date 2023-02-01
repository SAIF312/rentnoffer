

        @if ($users->status->title == 'new' || $users->status->title == 'disable' || $users->status->title == 'blocked' || $users->status->title == 'pending')
        <a onclick='ActiveUser({{ $users->id }})' type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
        @endif
        @if ($users->status->title == 'deactivated')
            <a onclick='ActiveUser({{ $users->id }})' type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
        @endif

        @if ($users->status->title == 'activated')
            <a onclick='DisableUser({{ $users->id }})' type="button" class="btn btn-secondary"><i class="fa-solid fa-x" aria-hidden="true"></i></a>
            <a onclick='BlockUser({{ $users->id }})' type="button" class="btn btn-warning"><i class="fa-regular fa-circle-xmark" aria-hidden="true"></i></a>
        @endif
        <a onclick='DeleteUser({{ $users->id }})' type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

