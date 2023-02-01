@if (isset($status_col))
    @if($page->status == 'Active')
        <span onclick='change_status({{ $page->id }},"{{$page->status}}")' class='badge badge-success' style='cursor:pointer;'>{{$page->status}}</span>
    @else
        <span onclick='change_status({{ $page->id }},"{{$page->status}}")' class='badge badge-danger' style='cursor:pointer;'>{{$page->status}}</span>
    @endif
@else
    {{-- <a onclick="view({{ $page->id }})" type="button" class="btn btn-danger"><i class="fa fa-eye" aria-hidden="true"></i></a> --}}
    {{-- <a href="{{route('pages.edit',['id'=>$page->id)}}" type="button" class="btn btn-danger"><i class="fa fa-edit"></i></a> --}}
    <a href="{{route('pages.show', $page->id)}}" type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
    <a href="{{route('pages.edit', $page->id)}}" type="button" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>

@endif
