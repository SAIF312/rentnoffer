{{-- <div class='btn-group'>
    <button type='button' class='btn btn-dark btn-sm'>Open</button>
    <button type='button' class='btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split' id='dropdownMenuReference2'
        data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-reference='parent'>
        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none'
            stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'
            class='feather feather-chevron-down'>
            <polyline points='6 9 12 15 18 9'></polyline>
        </svg>
    </button>
    <div class='dropdown-menu' aria-labelledby='dropdownMenuReference2'>
        @if ($attributes->status->title == 'new' || $attributes->status->title == 'disable')
            <a class='dropdown-item' style='cursor:pointer;' onclick='ActiveAttribute({{ $attributes->id }})'>Active</a>
        @endif
        @if ($attributes->status->title == 'active')
            <a class='dropdown-item' style='cursor:pointer;'
                onclick='DisableAttribute({{ $attributes->id }})'>Disable</a>
        @endif
        <a class='dropdown-item' style='cursor:pointer;' onclick='DeleteAttribute({{ $attributes->id }})'>Delete</a>

    </div>
</div> --}}
@if ($attributes->status->title == 'deactivated')
    <a  onclick='change_status({{ $attributes->id }},{{$attributes->status_id}})' type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></a>
@endif
@if ($attributes->status->title == 'activated')
    <a onclick='change_status({{ $attributes->id }},{{$attributes->status_id}})' type="button" class="btn btn-warning"><i class="fa-regular fa-circle-xmark" aria-hidden="true"></i></a>
@endif
    <a href="{{route('attributes.edit', $attributes->id)}}" type="button" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>
    <a onclick='delete_attribute({{ $attributes->id }})' type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>


