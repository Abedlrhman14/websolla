@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h2 class="mb-4">Add New Product</h2>

        {{-- this condation for any error within create --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error )
                            <li>{{$error}}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        {{-- this section is the form to create product --}}

        <form  action="{{ route('products.store') }}"  id="productForm" method="Post"  enctype="multipart/form-data">
            @csrf

            {{-- product Name --}}
            <div class="mb-3">
                <lable for='name' class="form-lable">Product Name</lable>
                <input type="text" name="name" class="form-control mt-2" value="{{old('name')}}">
            </div>

            {{-- Description  --}}
            <div class="mb-3">
                  <label for="description" class="form-lable mb-2">Description</label>
                  <textarea name="description" class="form-control">{{old('description')}}</textarea>
            </div>

            {{-- price --}}
            <div class="mb-3">
                <lable for='price' class="form-lable">price</lable>
                <input type="number" name="price" class="form-control mt-2" value="{{old('price')}}" step="0.01">
            </div>

            {{-- image --}}
            <div class="mb-3">
                <lable for='image' class="form-lable">Product Image</lable>
                <input type="file" name="image" class="form-control mt-2">
            </div>

            {{-- button for submit --}}
            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="{{route('products.index')}}" class="btn btn-secondary">Back</a>
        </form>
        <div id="result"></div>

        @section('scripts')

            <script>
                $('productForm').submit(function(e){
                    e.preventDefault();
                    let formData = new FormData(this);

                    $.ajax({
                          url : "{{ route('products.store') }}",
                        type:'post',
                        data: 'formData',
                        contentType:false,
                        processData:false,
                        success:function(response){
                          $('#result').html("<div class='alert alert-success'>Product Added successfully</div>");
                            $('#productForm')[0].reset();
                        },
                        error:function(xhr){
                            let errors = xhr.responseJSON.errors;
                            let errorHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors , function (key,value){
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('#result').html(errorHtml);
                        }
                    })
                })
            </script>
        @endsection
    </div>
@endsection
