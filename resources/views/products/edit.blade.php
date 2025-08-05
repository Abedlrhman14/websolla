@extends('layouts.app')
@section('content')

    <div class="container mt-4">
        <h2 class="mb-4">Edit Products</h2>

            {{-- this section for errors --}}
            @if($errors->any())
                <div class="alert alert-denger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error )
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="editProductForm" action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                {{-- Product Name --}}
                <div class="mb-3">
                    <lable for='name' class="form-lable">Product Name</lable>
                    <input type="text" name="name" class="form-control" value="{{old('name' , $product->name)}}">
                </div>

                 {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                 {{-- Price --}}
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01">
                </div>

                {{-- Existing Image --}}
                @if($product->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image:</label><br>
                        <img src="{{ asset('storage/' . $product->image) }}" style="height: 150px">
                    </div>
                @endif

                 {{-- Image --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Update Image</label>
                    <input type="file" name="image" class="form-control">
                </div>


                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                <div id="result"></div>
            </form>
    </div>
    @section('scripts')
        <script>
            $('#editProductForm').submit(function(e){
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{route('products.update' , $product->id)}}",
                    type:'post',
                    data:formData,
                    contentType:false,
                    processData:false,

                    success:function(response){
                         $('#result').html('<div class="alert alert-success">Product updated successfully!</div>');
                          window.location.href = response.redirect;
                    },
                    error:function(xhr){
                        let errors = xhr.responseJSON.errors;
                       let errorHtml = '<div class="alert alert-danger"><ul>';
                        $.each(errors , function(key,value){

                                errorHtml += '<li>' + value[0] + '</li>';
                        });
                            errorHtml += '</ul></div>';
                           $('#result').html(errorHtml);
                    }
                })
            })
        </script>
    @endsection
@endsection
