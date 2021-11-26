@extends('admin.admin')

@section('title', 'Product')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Product</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Product</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @elseif(session('failed'))
                <div class="alert alert-danger">
                    {{ session('failed') }}
                </div>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product</h3>
                    <div class="card-tools">
                        <a href="{{ route('product.create') }}" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                            Add
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    
                        <div class="row">
                            <div class="col">

                                <div class="form-group">
                                    {{ Form::label('category_id', 'Category') }}
                                    {{ Form::select('category_id', $categories, request('category_id'), ['class' => 'form-control', 'placeholder' => 'Choose category']) }}
                                </div>

                            </div>
                            <div class="col">

                                <div class="form-group">
                                    {{ Form::label('search', 'Search') }}
                                    {{ Form::text('search',  request('search'), ['class' => 'form-control', 'placeholder' => 'Search product']) }}
                                </div>

                            </div>
                        </div>
                    

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 100px">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        @if (!empty($product->image))
                                            <img src="{{ asset('storage/product/' . $product->image) }}" width="100" alt="">
                                        @else
                                            Tidak ada foto
                                        @endif
                                    </td>
                                    <td>{{ $product->status }}</td>
                                    <td>
                                        {{ Form::open(['route' => ['product.destroy', $product->id], 'method' => 'delete']) }}
                                            <div class="btn-group">
                                                <a href="{{ route('product.show', ['product' => $product->id]) }}" class="btn btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('product.edit', ['product' => $product->id]) }}" class="btn btn-success">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $products->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var filter = function () {

            var category_id = $('#category_id').val();
            var search = $('#search').val();

            window.location.replace("{{ route('product.index') }}?category_id=" + category_id + "&search=" + search);
        }

        $('#category_id').on('change', function () {
            filter();
        });

        $('#search').keypress(function (e) {
            if (e.keyCode == 13) {
                filter();
            }
        });
    </script>
@endsection