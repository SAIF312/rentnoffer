@if ($products->status->title == 'pending')
    <a onclick="accept_product({{ $products->id }})" type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
    <a onclick="reject_product({{ $products->id }})" type="button" class="btn btn-warning"><i class="fa-solid fa-x" aria-hidden="true"></i></a>{{-- Reject --}}
@else
    @if ($products->status->title == 'deactivated' || $products->status->title == 'disable')
        <a onclick='ActiveProduct({{ $products->id }})' type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
    @endif
    @if ($products->status->title == 'enable' ||
        $products->status->title == 'activated' ||
        $products->status->title == 'available')
        <a onclick='DisableProduct({{ $products->id }})'  type="button" class="btn btn-warning"><i class="fa-regular fa-circle-xmark" aria-hidden="true"></i></a>{{-- deactivate --}}
    @endif
    @if ($products->status->title == 'rejected')
        <a onclick='AcceptProduct({{ $products->id }})' type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
    @endif
        <a onclick='DeleteProduct({{ $products->id }})' type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
@endif
