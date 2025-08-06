@extends('layouts.app')

@section('content')

    <div class="container mt-4 ">
        {{-- this section for header to add products --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Products List</h2>
                <div>
                     <a href="{{route('products.create')}}" class="btn btn-success">Add Product</a>
                     <a href="{{route('orders')}} "class="btn btn-success">manage orders</a>
                </div>
        </div>
        <div class="row">
            {{-- this section for list the products --}}
            @foreach ($products as $product )
                <div class="col-md-4 mb-4 product-card product-card-{{ $product->id }}" >
                       {{-- this for catsh the photos from public --}}
                    <div class="card">
                        @if($product->image)
                            <img style="height: 250px" src='{{asset('storage/'.$product->image)}}' class='card-img-top 'alt='product photo'/>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text">{{$product->description}}</p>
                            <p class="card-text">{{$product->price}}EGP</p>
                        </div>

                        {{-- this section to make actions for the products --}}

                        <div class="card-footer text-center">
                            <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary btn-sm">Update</a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{$product->id}}">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @section('scripts')

            <script>
                $(document).on('click' , '.delete-btn' , function(){
                    if(!confirm('Are you sure?')) return;

                    let productId = $(this).data('id');
                    $.ajax({
                        url : '/products/'+productId,
                        type:'DELETE',
                        data:{
                            _token: '{{ csrf_token() }}',
                        },
                        success:function (response){
                            $('.product-card-' + productId).remove();
                        },
                        error:function (xhr){
                            alert('something wrong');
                        }
                    })
                  console.log(productId)
                  console.log('/products/' + productId);

                })
            </script>
        @endsection
    </div>

@endsection
