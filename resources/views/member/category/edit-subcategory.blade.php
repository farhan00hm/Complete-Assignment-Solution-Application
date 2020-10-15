@extends('member.template2')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-folder-plus"></i> Edit a Subcategory
            </h3>
        </div>
        
        <div class="content with-padding padding-bottom-10">
            <form method="post" action="/categories/sub-categories/update" id="subcategory" name="subcategory" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    @if ($message = Session::get('success'))
                        <div class="col-xl-12">
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                            </div>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="col-xl-12">
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="col-xl-6">
                        <div class="submit-field">
                            <h5>Category</h5>
                            <select class="selectpicker with-border" data-size="7" title="Select a category" id="category" name="category">
                                <option value="{{ $sub->category_id }}" selected="true">{{ $sub->category->name }}</option>
                                @foreach($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="submit-field">
                            <h5>Name</h5>
                            <input type="text" class="with-border" name="name" id="name" value="{{ $sub->name }}">
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <input type="hidden" name="id" id="id" value="{{ $sub->id }}">
                        <button type="submit" class="button ripple-effect big margin-top-20 margin-bottom-20" id="updateSubcategory">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#createCategory").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var name = $("#name").val();

                const formData = {'name':name, '_token':token};

                $.ajax({
                    url: '/categories/create',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) { 
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = "/categories";
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {  
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });
        }) 
    </script>
@endsection