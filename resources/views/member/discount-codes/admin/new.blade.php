@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-folder-plus"></i> New Discount Code
            </h3>
        </div>
        
        <div class="content with-padding padding-bottom-10">
            <div class="row">
                <div class="col-xl-6">
                    <div class="submit-field">
                        <h5>Amount</h5>
                        <input type="number" class="with-border" placeholder="Enter discount code amount" name="amount" id="amount">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="submit-field">
                        <h5>Comments<small>(Purpose for the discount. Max: 200 characters)</small></h5>
                        <textarea cols="30" rows="4" class="with-border" id="comments" name="comments"></textarea>
                    </div>
                </div>

                <div class="col-xl-12">
                    <button class="button ripple-effect big margin-top-20 margin-bottom-20" id="createDS">Create</button>
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
            $("#createDS").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var amount = $("#amount").val();
                var comments = $("#comments").val();

                const formData = {'amount':amount, 'comments':comments, '_token':token};

                $.ajax({
                    url: '/discount-codes/create',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) { 
                    if(data.success == 1){
                        success_snackbar(data.message, 6000)
                        setTimeout(function(){
                            window.location.href = "/discount-codes";
                        }, 6000);
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