@extends('auth.template')

@section('styles')
    <style type="text/css">
        .submit-field{
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">
                <section id="contact" class="margin-bottom-60">
                    <div>
                        <span id="response"></span>
                    </div>
                    <h3 class="headline margin-top-15 margin-bottom-35">Got a  questions? Talk to us!</h3>

                    <form method="post" name="contactform" id="contactform" autocomplete="on">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="name" type="text" id="name" placeholder="Your Name" required="required" />
                                    <i class="icon-material-outline-account-circle"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
                                    <i class="icon-material-outline-email"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-with-icon-left">
                            <input class="with-border" name="subject" type="text" id="subject" placeholder="Subject" required="required" />
                            <i class="icon-material-outline-assignment"></i>
                        </div>

                        <div>
                            <textarea class="with-border" name="comments" cols="40" rows="5" id="comments" placeholder="Your comments" spellcheck="true" required="required"></textarea>
                        </div>

                        <input type="submit" class="submit button margin-top-15" id="submit" value="Send" />

                    </form>
                </section>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#submit").click(function(e){
                e.preventDefault();

                var token = $("#token").val();

                var name = $("#name").val();
                var email = $("#email").val();
                var subject = $("#subject").val();
                var comments = $("#comments").val();

                const formData = {'name':name, 'email':email, 'subject':subject, 'comments':comments, '_token':token};

                $.ajax({
                    url: '/pages/contact-us',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) { 
                    if(data.success == 1){
                       $("#response").html('<div class="notification success closeable">'+
                            '<p>'+ data.message +'</p>'+
                            '<a class="close" href="#"></a>'+
                        '</div>');
                    }else{
                        $("#response").html('<div class="notification error closeable">'+
                            '<p>'+ data.error +'</p>'+
                            '<a class="close" href="#"></a>'+
                        '</div>');
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {  
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });
        })
    </script>
@endsection