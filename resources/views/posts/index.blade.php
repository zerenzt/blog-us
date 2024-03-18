@extends('layouts.master')

@section('header', 'post Dashboard')

@section('breadcrumb', 'post')
    
@section('content')
    
<div class="box">
    @include('flash_message')
    <div class="box-header">
        <a href="{{route('post.create')}}" class="btn btn-primary">
            Add Post
        </a>
    </div>
</div>

<!--box header-->
<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
        </div>
        <div class="row">
            <div class="com-sm-12">
                <table id="example2" class="table table-bordered table-hover dataTabble" role="grid" aria-describedby="example2_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending">SR.No</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser:activate to sort column ascending">post Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s):activate to sort column ascending">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Created At</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $post)
                        <tr role="row" class="odd">
                            <td class="sorting_1">#{{ $post->id }}</td>
                            <td>{{ $post->post_name }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                <textarea cols="40", rows="8", readonly>
                                    {{$post->description}}
                                </textarea>
                            </td>
                            <td>
                                @if($post->status == true)
                                    <span class="label label-success">Active</span>
                                @elseif($post->status == false)
                                    <span class="label label-danger">Block</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" onclick="editpost({{$post->id}})">;
                                        <a href="{{route('post.edit',$post->id)}}" class="btn btn-primary">Edit</a> I
                                        <a href="{{route('post.delete',$post->id)}}" class="btn btn-danger">Del</a> I
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse                        
                    </tbody>
                </table>
            </div>    
        </div>
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
