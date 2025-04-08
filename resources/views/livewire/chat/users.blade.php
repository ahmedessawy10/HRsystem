<div class="sidebar">
    <div class="sidebar-content card d-none d-lg-block">
        <div class="card-body chat-fixed-search">
            <fieldset class="form-group position-relative has-icon-left m-0">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search user"
                    wire:loading.attr="disabled">
                <div class="form-control-position">
                    <i class="ft-search" wire:loading.remove></i>
                    <i class="la la-spinner spinner" wire:loading></i>
                </div>
            </fieldset>
        </div>

        <!-- Add loading spinner -->
        <div wire:loading class="text-center my-3">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div id="users-list" class="list-group position-relative" wire:loading.class="opacity-50">
            <div class="users-list-padding media-list">

                @forelse( $users as $user)
                <button type="button" wire:click="openChat({{$user->id}})"
                    class="media border-0 w-100 {{($user->id == $activeUser)? "active": ""}}">
                    <div class="media-left pr-1 ">
                        <span class="avatar avatar-md avatar-online">
                            <img class="media-object rounded-circle"
                                src="../../../app-assets/images/portrait/small/avatar-s-3.png"
                                alt="Generic placeholder image">
                            <i></i>
                        </span>
                    </div>
                    @php
                    $lastMessage=$user->chats()->latest()->where(function($q) {
                    $q->where("sender_id", Auth::id())->orWhere("receiver_id", Auth::id());
                    })->take(1)->first();

                    @endphp
                    <div class="media-body w-100">
                        <h6 class="list-group-item-heading">
                            {{ $user->fullname }}
                            @if($unreadCount = $user->chats()->where('receiver_id', Auth::id() )->where("sender_id",
                            $user->id)->where('is_read', false)->count())
                            <span class="badge badge-pill badge-primary float-right">{{ $unreadCount }}</span>
                            @endif
                        </h6>

                        @if($lastMessage)
                        <span
                            class="font-small-3 float-right info">{{  $lastMessage->created_at->format("h:m i")}}</span>
                        @endif
                        </h6>

                        @if($lastMessage)
                        <p class="list-group-item-text text-muted mb-0"><i class="ft-check primary font-small-2"></i>

                            {{$lastMessage->sender_id==Auth::id() ? __("you"): $user->fullname }} :
                            {{ $lastMessage->message }}
                            <span class="float-right primary"><i
                                    class="font-medium-1 icon-pin blue-grey lighten-3"></i></span>
                        </p>
                        @endif
                    </div>
                </button>

                @empty


                @endforelse



            </div>
        </div>
    </div>
</div>