@extends('member.template')

@section('content')
    <div class="messages-container margin-top-10">
        <div class="messages-container-inner">
            <p style="padding: 20px;">No messages yet</p>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('member/js/messaging.js') }}"></script>
@endsection