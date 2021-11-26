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
            {{ Form::open(['route' => ['product.update', $product->id], 'method' => 'put', 'files' => true]) }}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit product</h3>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($product->image))
                            <img src="{{ asset('storage/product/' . $product->image) }}" width="400" alt="">
                        @endif

                        <div class="row">
                            <div class="col">
                                
                                <div class="form-group">
                                    {{ Form::label('category_id', 'Category') }}
                                    {{ Form::select('category_id', $categories, $product->category_id, ['class' => 'form-control', 'placeholder' => 'Choose category']) }}
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    {{ Form::label('name', 'Name') }}
                                    {{ Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => 'Enter name']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('price', 'Price') }}
                                    {{ Form::number('price', $product->price, ['class' => 'form-control', 'placeholder' => 'Enter price']) }}
                                </div>

                            </div>
                            <div class="col">

                                <div class="form-group">
                                    {{ Form::label('sku', 'SKU') }}
                                    {{ Form::text('sku', $product->sku, ['class' => 'form-control', 'placeholder' => 'Enter SKU']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('status', 'Status') }}
                                    {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], $product->status, ['class' => 'form-control', 'placeholder' => 'Choose status']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('image', 'Image') }}
                                    <div class="custom-file">
                                        {{ Form::label('image', 'Choose image', ['class' => 'custom-file-label']) }}
                                        {{ Form::file('image', ['class' => 'custom-file-input']) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', $product->description, ['class' => 'form-control', 'placeholder' => 'Enter description', 'rows' => '3']) }}
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-info">Back</a>
                        <button type="submit" class="btn btn-success float-right">Edit product</button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
