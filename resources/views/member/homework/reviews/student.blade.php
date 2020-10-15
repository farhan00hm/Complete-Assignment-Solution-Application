@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3>Leave a Review</h3>
            @if(Auth::user()->user_type == 'FL')
                <span>Rate <a href="#">{{ App\User::where('id', $hw->posted_by)->first()->username }}</a> for the homework <a
                        href="/homeworks/single/{{ $hw->uuid }}">{{ $hw->title }}</a> </span>
            @else
                <span>Rate <a href="#">{{ $hw->awardedTo->username }}</a> for the homework <a
                        href="/homeworks/single/{{ $hw->uuid }}">{{ $hw->title }}</a> </span>
            @endif
        </div>
        <div style="padding: 20px 30px;">
            <form method="post" id="leave-review-form">
                <div class="feedback-yes-no">
                    <strong>Your Rating</strong>
                    <div class="leave-rating">
                        <input type="radio" name="rating" id="rating-radio-1" value="1" required>
                        <label for="rating-radio-1" class="icon-material-outline-star"></label>
                        <input type="radio" name="rating" id="rating-radio-2" value="2" required>
                        <label for="rating-radio-2" class="icon-material-outline-star"></label>
                        <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                        <label for="rating-radio-3" class="icon-material-outline-star"></label>
                        <input type="radio" name="rating" id="rating-radio-4" value="4" required>
                        <label for="rating-radio-4" class="icon-material-outline-star"></label>
                        <input type="radio" name="rating" id="rating-radio-5" value="5" required>
                        <label for="rating-radio-5" class="icon-material-outline-star"></label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <textarea class="with-border" placeholder="Your review" name="review" id="review" cols="7"
                          required></textarea>
                <input type="hidden" name="hwId" id="hwId" value="{{ $hw->id }}">
                <input type="hidden" name="prev" id="prev" value="{{ $prev }}">
            </form>

            <button class="button button-sliding-icon ripple-effect" id="postReview" type="submit"
                    form="leave-review-form">Leave a Review <i class="icon-material-outline-arrow-right-alt"></i>
            </button>
        </div>
    </div>

@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#postReview").click(function (e) {
                e.preventDefault();

                var token = $("#token").val();
                var rating = $("input[name='rating']:checked").val();
                var review = $("#review").val();
                var hwId = $("#hwId").val();
                var prev = $("#prev").val();

                const formData = {'rating': rating, 'review': review, 'hwId': hwId, '_token': token};

                $.ajax({
                    url: '/homeworks/student/review',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                    .done(function (data) {
                        if (data.success == 1) {
                            success_snackbar(data.message, 3000)
                            setTimeout(function () {
                                window.location.href = prev;
                            }, 3000);
                        } else {
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
