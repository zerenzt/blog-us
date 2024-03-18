@extends('layouts.master')

@section('header', 'Category Dashboard')

@section('breadcrumb', 'Category')
    
@section('content')
    
<div class="box">
    @include('flash_message')
    <div class="box-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#category-add">
            Add Category
        </button>
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
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser:activate to sort column ascending">Category Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s):activate to sort column ascending">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Created At</th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr role="row" class="odd">
                            <td class="sorting_1">#{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                @if($category->status == true)
                                    <span class="label label-success">Active</span>
                                @elseif($category->status == false)
                                    <span class="label label-danger">Block</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" onclick="editCategory({{$category->id}})">;
                                        <a href="{{route('category.delete',$category->id)}}" class="btn btn-danger">Del</a> I
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

{{-- Create Category Modal --}}
    
<div class="modal fade" id="category-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Category</h4>
            </div>
            @include('flash_message')
            <div class="modal-body">
                <form role="form" action="{{ route('category.update') }}" method="POST">
                    <input type="hidden" id="category_id" name="category_id">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="category_edit">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="inputCategory" placeholder="Enter category name>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="1">Block</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-dafault pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('extra_script')
<script type="text/javascript">
    @if (count($errors)>0)
        $('#category-add').modal('show');
    @endif
</script>

{{-- For edit category --}}
<script>
    function editCategory(id){
        var category_id = id;
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
    type: 'POST',
    url: '{{ route("category.update") }}',
    data: {id: category_id},

    success: function(data) {
        $('#category_id').val(data.id);
        $('#category_edit').val(data.category_name);
        $('#status').val(data.status);
        $('#category-edit').modal('show');
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
    }
});

    }
</script>
@endpush
