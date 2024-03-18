@extends('layouts.master')

@section('header', 'post Dashboard')

@section('breadcrumb', 'post')
    
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

<!--box header-->
{{-- <- form stort --> --}}

<form role="form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="box-body">
            <div class="form-group">
                <label for="post">Category</label>
                <select class="form-control" name="category_id">
                    <option value="" selected>Select Category</option>
                    @forelse (cache()->get('categories') as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name}}</option>
                    
                    @empty
                    
                    @endforelse
                </select>
            </div>

            <div class="form-group">
                <label for="post">Title</label>           
                <input type="text" class="form-control" name="title" id="post" placeholder="Enter Post Title">
            </div>  

            <div class="form-group">
                <label for="description">Description</label>   
                <textarea class="form-control" cols="40" rows="10" name="description" id="description">
                </textarea>
            </div>
                
            <div class="form-group">
                <label for="image"> Image</label>
                <input type="file" id="image" name="image">
            </div>
            
            <div class="form-group">
                <label for="post">Status</label>       
                <select class="form-control" name="status">
                    <option value="1" selected>Active</option>
                    <option value="0">Block</option>
                </select>
            </div>    
        </div>
                
                {{-- <1--box-body--> --}}
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>    

@endsection

@push('extra_script')
<script type="text/javascript">
    @if (count($errors)>0)
        $('#post-add').modal('show');
    @endif
</script>

{{-- For edit post --}}
<script>
    function editpost(id){
        var post_id = id;
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
    type: 'POST',
    url: '{{ route("post.update") }}',
    data: {id: post_id},

    success: function(data) {
        $('#post_id').val(data.id);
        $('#post_edit').val(data.post_name);
        $('#status').val(data.status);
        $('#post-edit').modal('show');
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
    }
});

    }
</script>
@endpush
