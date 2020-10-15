@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3>Ongoing Homework</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($hws->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You do not have any ongoing homeworks</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped " id="cats-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Hired On</th>
                                <th>Amount</th>
                                <th>Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hws as $hw)
                                <tr>
                                    <td>
                                        <a style="color: #00a554" href="/homeworks/single/{{ $hw->uuid }}">
                                            {{ $hw->title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($hw->deadline)->isoFormat('MMM Do') }}
                                    </td>
                                    <td>
                                        @if(!empty($hw->hired_on))
                                            {{ \Carbon\Carbon::parse($hw->hired_on)->isoFormat('MMM Do, h:mm A') }}
                                        @endif
                                    </td>
                                    <td>{{ $hw->winning_bid_amount }}</td>
                                    <td>
                                        <a class="btn-info button mb-10" style="color: #ffffff; line-height: 20px; box-shadow: none; background-color: #17a2b8 !important;" href="/homeworks/submit/{{ $hw->uuid }}">
                                            Submit
                                        </a>
                                    </td>
                                    <td>
                                        <a class="delete" style="color: #a62026" href="#" data-code="{{ $hw->uuid }}" title="Delete homework">
                                            <i class="icon-feather-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div>&nbsp;</div>
            <div>
                {{ $hws->links() }}
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
            $("#cats-table tbody").on("click", ".delete", function(e){

                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');
                
                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/so/homeworks/delete',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) { 
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            location.reload();
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