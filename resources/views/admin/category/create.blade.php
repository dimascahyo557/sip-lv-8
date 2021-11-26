@extends('admin.admin')

@section('title', 'Category')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Category</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Category</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <form action="{{ url('admin/category') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add category</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" placeholder="Enter name">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">-- select status --</option>
                                <option value="active" @if(old('status') == 'active') selected @endif>active</option>
                                <option value="inactive" @if(old('status') == 'inactive') selected @endif>inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
    
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('admin/category') }}" class="btn btn-outline-info">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Add category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
