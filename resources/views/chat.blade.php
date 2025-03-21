@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection
@section("css")

<link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/chat-application.css")}}">


@endsection

@section("content")
<div class="chat-application">
    <div class="app-content content">
        <div class="sidebar-left sidebar-fixed">
            <div class="sidebar">
                <div class="sidebar-content card d-none d-lg-block">
                    <div class="card-body chat-fixed-search">
                        <fieldset class="form-group position-relative has-icon-left m-0">
                            <input type="text" class="form-control" id="iconLeft4" placeholder="Search user">
                            <div class="form-control-position">
                                <i class="ft-search"></i>
                            </div>
                        </fieldset>
                    </div>
                    @livewire('chat.users')
                    <div id="users-list" class="list-group position-relative">
                        <div class="users-list-padding media-list">
                            <a href="#" class="media border-0">
                                <div class="media-left pr-1">
                                    <span class="avatar avatar-md avatar-online">
                                        <img class="media-object rounded-circle"
                                            src="../../../app-assets/images/portrait/small/avatar-s-3.png"
                                            alt="Generic placeholder image">
                                        <i></i>
                                    </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading">Elizabeth Elliott
                                        <span class="font-small-3 float-right info">4:14 AM</span>
                                    </h6>
                                    <p class="list-group-item-text text-muted mb-0"><i
                                            class="ft-check primary font-small-2"></i> Okay
                                        <span class="float-right primary"><i
                                                class="font-medium-1 icon-pin blue-grey lighten-3"></i></span>
                                    </p>
                                </div>
                            </a>

                            <a href="#" class="media border-0">
                                <div class="media-left pr-1">
                                    <span class="avatar avatar-md avatar-online">
                                        <img class="media-object rounded-circle"
                                            src="../../../app-assets/images/portrait/small/avatar-s-3.png"
                                            alt="Generic placeholder image">
                                        <i></i>
                                    </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading">Elizabeth Elliott
                                        <span class="font-small-3 float-right info">4:14 AM</span>
                                    </h6>
                                    <p class="list-group-item-text text-muted mb-0"><i
                                            class="ft-check font-small-2"></i>
                                        Okay
                                        <span class="float-right primary"><i
                                                class="font-medium-1 icon-pin blue-grey lighten-3"></i></span>
                                    </p>
                                </div>
                            </a>
                            <a href="#" class="media border-0">
                                <div class="media-left pr-1">
                                    <span class="avatar avatar-md avatar-busy">
                                        <img class="media-object rounded-circle"
                                            src="../../../app-assets/images/portrait/small/avatar-s-7.png"
                                            alt="Generic placeholder image">
                                        <i></i>
                                    </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading">Kristopher Candy
                                        <span class="font-small-3 float-right info">9:04 PM</span>
                                    </h6>
                                    <p class="list-group-item-text text-muted mb-0"><i
                                            class="ft-check primary font-small-2"></i> Thank you
                                        <span class="float-right primary">
                                            <span class="badge badge-pill badge-danger">12</span>
                                        </span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="chat-app-window">
                        <div class="badge badge-default mb-1">Chat History</div>
                        <div class="chats">
                            <div class="chats">
                                <div class="chat">
                                    <div class="chat-avatar">
                                        <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                                            data-original-title="">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-1.png"
                                                alt="avatar" />
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            <p>How can we help? We're here for you!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat chat-left">
                                    <div class="chat-avatar">
                                        <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title=""
                                            data-original-title="">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-7.png"
                                                alt="avatar" />
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            <p>Hey John, I am looking for the best admin template.</p>
                                            <p>Could you please help me to find it out?</p>
                                        </div>
                                        <div class="chat-content">
                                            <p>It should be Bootstrap 4 compatible.</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- <p class="time">1 hours ago</p> --}}

                            </div>
                        </div>
                    </section>
                    <section class="chat-app-form" class="">
                        <form class="chat-app-input d-flex" id="chatbot">
                            <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                                <div class="form-control-position">
                                    <i class="icon-emoticon-smile"></i>
                                </div>
                                <input type="text" class="form-control" id="message" placeholder="Type your message">
                                <div class="form-control-position control-position-right">
                                    <i class="ft-image"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                                <button type="button" class="btn btn-info"><i class="la la-paper-plane-o d-lg-none"></i>
                                    <span class="d-none d-lg-block">Send</span>
                                </button>
                            </fieldset>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




@section("js")

<script src="{{ asset("app-assets/js/scripts/pages/chat-application.js") }}" type="text/javascript"></script>

<script>
    //Broadcast messages
    $("#chatbot").submit(function (event) {
      event.preventDefault();
  
      //Stop empty messages
      if ($("form #message").val().trim() === '') {
        return;
      }
  
      //Disable form
      $("form #message").prop('disabled', true);
      $("form button").prop('disabled', true);
  
      $.ajax({
        url: "/aichat",
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
        },
        data: {
          "model": "gpt-3.5-turbo",
          "content": $("form #message").val()
        }
      }).done(function (res) {
  
        //Populate sending message
        $(".messages > .message").last().after('<div class="right message">' +
          '<p>' + $("form #message").val() + '</p>' +
          '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
          '</div>');
  
        //Populate receiving message
        $(".messages > .message").last().after('<div class="left message">' +
          '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
          '<p>' + res + '</p>' +
          '</div>');
  
        //Cleanup
        $("form #message").val('');
        $(document).scrollTop($(document).height());
  
        //Enable form
        $("form #message").prop('disabled', false);
        $("form button").prop('disabled', false);
      });
    });
  
</script>

@endsection