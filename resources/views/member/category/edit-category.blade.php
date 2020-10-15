@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-folder-plus"></i> Edit a Category
            </h3>
        </div>
        
        <div class="content with-padding padding-bottom-10">
            <div class="row">
                <div class="col-xl-6">
                    <div class="submit-field">
                        <h5>Name</h5>
                        <input type="text" class="with-border" placeholder="e.g. Mathematics" name="name" id="name" value="{{ $cat->name }}">
                        <input type="hidden" name="id" id="id" value="{{ $cat->id }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <button class="button ripple-effect big margin-top-20 margin-bottom-20" id="updateCategory">Update</button>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#updateCategory").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var id = $("#id").val();
                var name = $("#name").val();

                const formData = {'id':id, 'name':name, '_token':token};

                $.ajax({
                    url: '/categories/update',
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