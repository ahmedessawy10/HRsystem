<div class="content-wrapper">

    @if ($user)
    <div class="content-body">
        <div class="content-header row">
            <div class="d-flex justify-content-between w-100 align-items-center">
                <span>{{ $user->name ?? __('project.no_user')}}</span>
                <button wire:click="closeChat" class="btn btn-sm btn-outline-danger">
                    <i class="la la-times"></i>
                </button>
            </div>
        </div>

        <section class="chat-app-window">
            <div class="badge badge-default mb-1">{{ __('project.chat_history') }}</div>

            <!-- Add loading spinner -->
            <div wire:loading wire:target="getMessage, sendMessage" class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">{{ __('project.loading') }}</span>
                </div>
            </div>

            <div class="chats" wire:loading.class="opacity-50" id="chat-container">
                <div class="chats">
                    @forelse ($messages as $data => $mess)
                    <div class="date-divider">
                        {{ $data }}
                    </div>
                    @foreach ($mess as $message)
                    <div class="chat {{$message['sender_id'] == Auth::id() ? "" : "chat-left"}}">
                        <div class="chat-avatar">
                            <a class="avatar" data-toggle="tooltip" href="#"
                                data-placement="{{$message['sender_id'] == Auth::id() ? "right" : "left"}}" title=""
                                data-original-title="">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar" />
                            </a>
                        </div>
                        <div class="chat-body">
                            <div class="chat-content">
                                <p>{{$message['message']}}</p>
                                @if($message['sender_id'] == Auth::id())
                                <small class="text-muted">
                                    <i
                                        class="la {{ $message['is_read'] ? 'la-check-double text-success' : 'la-check' }}"></i>
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @empty
                    <div class="text-center text-muted">
                        {{ __('project.no_messages') }}
                    </div>
                    @endforelse
                </div>
            </div>
            <script>
                document.addEventListener('livewire:initialized', () => {
                    const scrollToBottom = () => {
                        const container = document.getElementById('chat-container');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    };
                    scrollToBottom();
                    Livewire.on('messageReceived', () => {
                        scrollToBottom();
                    });
                });
            </script>
        </section>
        <section class="chat-app-form" class="">
            <form class="chat-app-input d-flex" id="chatbot" wire:submit="sendMessage({{$user}})">
                <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                    <div class="form-control-position">
                        <i class="icon-emoticon-smile"></i>
                    </div>
                    <input type="text" class="form-control" id="message" wire:model="message"
                        placeholder="{{ __('project.type_your_message') }}">
                    <div class="form-control-position control-position-right">
                        <i class="ft-image"></i>
                    </div>
                </fieldset>
                <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                    <button type="button" class="btn btn-info"><i class="la la-paper-plane-o d-lg-none"></i>
                        <span class="d-none d-lg-block">{{ __('project.send') }}</span>
                    </button>
                </fieldset>
            </form>
        </section>
    </div>

    @else



    @endif

</div>