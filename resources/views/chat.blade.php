@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection
@section("css")

<style>
  .active {
    background-color: #1E9FF2 !important;
    color: #fff !important;
  }

  .active:hover {
    background-color: #1E9FF2 !important;
    color: #fff !important;
  }
</style>


<link rel="stylesheet" type="text/css" href="{{asset("app-assets/css/pages/chat-application.css")}}">

@vite(["resources/js/app.js"])
@endsection

@section("content")
<div class="chat-application">
  <div class="app-content content">
    <div class="sidebar-left sidebar-fixed">
      @livewire('chat.users')

    </div>
    <div class="content-right">

      @livewire("chat.messages")
    </div>
  </div>
</div>

@endsection




@section("js")

{{-- <script src="{{ asset("app-assets/js/scripts/pages/chat-application.js") }}" type="text/javascript"></script> --}}

<script>
  //Broadcast messages
    // $("#chatbot").submit(function (event) {
    //   event.preventDefault();
  
    //   //Stop empty messages
    //   if ($("form #message").val().trim() === '') {
    //     return;
    //   }
  
    //   //Disable form
    //   $("form #message").prop('disabled', true);
    //   $("form button").prop('disabled', true);
  
    //   $.ajax({
    //     url: "/aichat",
    //     method: 'POST',
    //     headers: {
    //       'X-CSRF-TOKEN': "{{csrf_token()}}"
    //     },
    //     data: {
    //       "model": "gpt-3.5-turbo",
    //       "content": $("form #message").val()
    //     }
    //   }).done(function (res) {
  
    //     //Populate sending message
    //     $(".messages > .message").last().after('<div class="right message">' +
    //       '<p>' + $("form #message").val() + '</p>' +
    //       '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
    //       '</div>');
  
    //     //Populate receiving message
    //     $(".messages > .message").last().after('<div class="left message">' +
    //       '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
    //       '<p>' + res + '</p>' +
    //       '</div>');
  
    //     //Cleanup
    //     $("form #message").val('');
    //     $(document).scrollTop($(document).height());
  
    //     //Enable form
    //     $("form #message").prop('disabled', false);
    //     $("form button").prop('disabled', false);
    //   });
    // });
  
   console.log(window.Echo);
    
</script>

@endsection