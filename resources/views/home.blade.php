@extends('layouts.app')
@section('content')

    <div class="container mt-4">
        <h2 class="mb-4">All Products</h2>
        <div class="row">
            @forelse ($products as $product )
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($product->image)
                            <img src="{{asset('storage/'.$product->image)}}" class="card-image-top" style="height: 250px">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <p class="card-text flex-grow-1">{{$product->description}}</p>
                            <p class="card-text"><strong>{{$product->price}}EGP</strong></p>

                            {{-- Button to add to card --}}
                            <div class="card-footer text-center">
                             <button class="btn btn-primary add-to-card-btn" data-id="{{ $product->id }}">Add to Cart</button>
                          </div>
                        </div>
                    </div>
                </div>
            @empty
                  <p>No products available right now.</p>
            @endforelse
        </div>
    </div>

    {{-- Ajax --}}
    @section('scripts')
        <script>
            $(document).on('click' , '.add-to-card-btn' , function(){
                let productId = $(this).data('id');
                console.log(productId)
                $.ajax({
                    url:'/cart/add',
                    type:'post',
                    data:{
                        _token:'{{csrf_token()}}',
                        product_id:productId
                    },
                    success:function(response){
                        alert(response.message);
                    },
                    error:function(){
                        alert('Failed to add to cart.')
                    }
                })
            })
        </script>
    @endsection
@endsection
