@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3>Counter Offers</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($offers->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have not been offered any counter bids.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped counter-table">
                        <thead>
                            <tr>
                                <th>Homework Title</th>
                                <th>Bid Amount</th>
                                <th>Counter Amount</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offers as $offer)
                                <tr>
                                    <td>
                                        <a href="/homeworks/single/{{ $offer->bid->homework->uuid }}" title="View homework details">
                                            {{ $offer->bid->homework->title }}
                                        </a>
                                    </td>
                                    <td>&#8358; {{ $offer->bid->amount }}</td>
                                    <td>&#8358; {{ $offer->amount }}</td>
                                    <td>
                                        <button class="btn-success button accept" style="color: #ffffff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;" title="Decline counter offer" href="#" data-code="{{ $offer->id }}">
                                            Accept
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn-danger button decline" title="Decline counter offer" style="color: #ffffff;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" href="#" data-code="{{ $offer->id }}">
                                            Decline
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
                {{ $offers->links() }}
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
            $(".counter-table tbody").on("click", ".decline", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var counterId = $(this).attr('data-code');

                const formData = {'counterId':counterId, '_token':token};

                $.ajax({
                    url: '/bids/counter-offers/decline',
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

            $(".counter-table tbody").on("click", ".accept", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var counterId = $(this).attr('data-code');

                const formData = {'counterId':counterId, '_token':token};

                $.ajax({
                    url: '/bids/counter-offers/accept',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = '/freelancer/homeworks/ongoing';
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
