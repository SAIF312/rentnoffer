{{-- <a onclick="view({{ $order->id }})" type="button" class="btn btn-danger"><i class="fa fa-eye" aria-hidden="true"></i></a> --}}
{{-- <a href="{{route('orders.edit',['id'=>$order->id)}}" type="button" class="btn btn-danger"><i class="fa fa-edit"></i></a> --}}
<a href="{{route('orders.show', $order->id)}}" type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
{{-- <a href="{{route('orders.edit', $order->id)}}" type="button" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a> --}}
