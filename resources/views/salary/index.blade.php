@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection

@section("css")
{{-- Remove or update DataTables CSS as it might conflict with Livewire --}}
<link rel="stylesheet" href="{{ asset("app-assets/css/tablestyle.css") }}">
@livewireStyles

<style>
  /* Enhance Pagination Styles */
  .pagination {
    justify-content: center;
    margin-top: 20px;
  }

  .pagination .page-link {
    border-radius: 50px;
    padding: 10px 20px;
    margin: 0 5px;
    background-color: #e9ecef;
    color: #007bff;
    border: none;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
  }

  .pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
    transform: scale(1.1);
  }

  .pagination .active .page-link {
    background-color: #007bff;
    color: #fff;
  }

  .pagination .disabled .page-link {
    background-color: #f5f5f5;
    color: #6c757d;
  }

  /* Customize pagination dots */
  .pagination .page-item.disabled .page-link {
    cursor: not-allowed;
    pointer-events: none;
  }
</style>
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
                                <h4 class="card-title">{{__('app.show_salaries')}}</h4>
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
