@if ($categories->status->title == 'pending' || $categories->status->title == 'deactivated')
    <a  onclick='ActiveCategory({{ $categories->id }})' type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></a>
@endif
@if ($categories->status->title == 'activated')
    <a onclick='DisableCategory({{ $categories->id }})' type="button" class="btn btn-warning"><i class="fa-regular fa-circle-xmark" aria-hidden="true"></i></a>
@endif
    <a href="{{route('categories.edit', $categories->id)}}" type="button" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>
    <a onclick='DeleteCategory({{ $categories->id }})' type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

