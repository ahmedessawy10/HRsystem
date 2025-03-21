@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection

@section("css")
{{-- Remove or update DataTables CSS as it might conflict with Livewire --}}
@livewireStyles
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('app.show_salays')}}</h4>
                            </div>
                            <div class="card-content collapse show">
                                {{-- @livewire('salary-table')  --}}
                                @livewire('salary-v2')

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section("js")
{{-- Remove DataTables JS as it might conflict with Livewire --}}
@livewireScripts

{{-- Add Alpine.js if you're using Livewire v3 --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection