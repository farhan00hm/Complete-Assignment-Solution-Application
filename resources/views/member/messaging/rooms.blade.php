@extends('member.template')

@section('content')
    <div class="messages-container margin-top-10">
        
            <div class="messages-container-inner">
                <div class="messages-inbox">
                    <div class="messages-headline" style="margin-top: -6px !important;">
                        &nbsp;<br>&nbsp;
                    </div>
                    <ul id="chats">
                        @if(Auth::user()->user_type == "Admin" || Auth::user()->user_type == "Subadmin")
                            @foreach($rooms as $room)
                                <li <?php if ($room->uuid == $currentRoom->uuid) {
                                    echo  'class="active-message"';;
                                } ?> >
                                    <a href="/messages/{{ $room->uuid }}">
                                        <div class="message-avatar"><i class="status-icon status-online"></i><img src="{{ asset('img/user-avatar-placeholder.png') }}" alt="" /></div>
                                        <div class="message-by">
                                            <div class="message-by-headline">
                                                <h5>{{ $room->messageFrom->first_name }} {{ $room->messageFrom->last_name }}</h5>
                                                <span>{{ $room->updated_at->diffForHumans() }}</span>
                                            </div>
                                            <p>{{ $room->last_message }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @foreach($rooms as $room)
                                <li>
                                    <a href="/messages/{{ $room->uuid }}">
                                        <div class="message-avatar"><i class="status-icon status-online"></i><img src="{{ asset('img/user-avatar-placeholder.png') }}" alt="" /></div>
                                        <div class="message-by">
                                            <div class="message-by-headline">
                                                <h5>{{ $room->messageTo->first_name }} {{ $room->messageTo->last_name }}</h5>
                                                <span>
                                                    {{ $room->updated_at->diffForHumans() }} 
                                                </span>
                                            </div>
                                            <p>{{ $room->last_message }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                
                <!-- Message Content -->
                <div class="message-content">
                    <div class="messages-headline">
                        @if(Auth::user()->user_type == "Admin" || Auth::user()->user_type == "Subadmin")
                            <h4>{{ $currentRoom->messageFrom->first_name }} {{ $currentRoom->messageFrom->last_name }}</h4>
                        @else
                            <h4>{{ $currentRoom->messageTo->first_name }} {{ $currentRoom->messageTo->last_name }} (Admin)</h4>
                            <a href="#" data-code="{{ $currentRoom->uuid }}" class="message-action delete"><i class="icon-feather-trash-2"></i> Delete Conversation</a>
                        @endif
                    </div>

                    <!-- Message Content Inner -->
                    @if($threads->count() > 0)
                        <div class="message-content-inner" id="thread">
                            @foreach($threads as $th)
                                @if($th->from == $from)
                                    <div class="message-bubble me">
                                        <div class="message-bubble-inner">
                                            <div class="message-text">
                                                <p>
                                                    {{ $th->message }}
                                                    <br><small style="float: right;">
                                                        {{ $th->created_at->diffForHumans() }} 
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @else
                                    <div class="message-bubble">
                                        <div class="message-bubble-inner">
                                            <div class="message-text">
                                                <p>
                                                    {{ $th->message }}
                                                    <br><small style="float: left;">
                                                        {{ $th->created_at->diffForHumans() }} 
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- Reply Area -->
                    <div class="message-reply">
                        <textarea id="message" name="message" cols="1" rows="1" placeholder="Type your message here ... "></textarea>
                        <input type="hidden" name="roomId" id="roomId" value="{{ $currentRoom->id }}">
                        <button class="button ripple-effect" id="send">Send</button>
                    </div>
                </div>
            </div>
        
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('member/js/messaging.js') }}"></script>
@endsection