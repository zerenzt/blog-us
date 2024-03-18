@extends('layouts.master')

@section('header', 'Edit Post')

@section('breadcrumb', 'Edit')
    
@section('content')

<div class="box">
    @include('flash_message')

    <div class="box box-primary">
        <div class="box-header with-border">
            <a href="{{route('post.index')}}" class="btn btn-primary pull-right">
                Back
            </a>
        </div>
    </div>
</div> 

{{-- <- form stort --> --}}

<form role="form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="box-body">
            <div class="form-group">
                <label for="post">Category</label>
                <select class="form-control" name="category_id">
                    <option value="" selected>Select Category</option>
                    @forelse (cache()->get('categories') as $category)
                    <option value="{{ $category->id }}">{{ $category->id == $post->category_id? 'selected':''}}>{{$category->category_name}}</option>
                    
                    @empty
                    
                    @endforelse
                </select>
            </div>

            <div class="form-group">
                <label for="post">Title</label>           
                <input type="text" class="form-control" name="title" value="{{$post->title}}" placeholder="Enter Post Title">
            </div>  

            <div class="form-group">
                <label for="description">Description</label>   
                <textarea class="form-control" cols="40" rows="10" name="description" id="description">
                    {{$post->description}}
                </textarea>
            </div>
                
            <div class="form-group">
                <label for="image"> Image</label>
                <input type="file" id="image" name="image">
            </div>
            
            <div class="form-group">
                <label for="post">Status</label>       
                <select class="form-control" name="status">
                    <option value="1" {{$post->status == '1'? 'selected':''}}>Active</option>
                    <option value="0" {{$post->status == '0'? 'selected':''}}>Block</option>
                </select>
            </div>    
        </div>
                
                {{-- <1--box-body--> --}}
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form> 
        </div>
    </div>    

@endsection