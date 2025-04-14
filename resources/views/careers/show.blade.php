@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection
@section("css")




@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-9">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-header bg-transparent border-bottom">
                                <h4 class="card-title fw-bold mb-0">{{ $career->title }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="mt-4 mb-4">
                                            <h5 class="fw-bold text-primary mb-3">
                                                {{ __('app.job description') }}
                                            </h5>
                                            <p class="lead text-muted">{{ $career->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="fw-bold mb-0">{{__('app.career details')}}</h5>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('careers.edit', $career->id) }}"
                                            class="btn btn-warning btn-sm me-2">
                                            <i class="fa fa-edit"></i> {{__('app.edit')}}
                                        </a>
                                        <form action="{{ route('careers.destroy', $career->id) }}" method="POST"
                                            class="d-inline" id="deleteCareer">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> {{__('app.delete')}}
                                            </button>
                                        </form>
                                    </div>

                                    <div class="career-details">
                                        <div class="mb-3 pb-2 border-bottom">
                                            <small class="text-muted">{{__('app.department')}}</small>
                                            <div class="fw-bold">{{$career->department->name}}</div>
                                        </div>
                                        <div class="mb-3 pb-2 border-bottom">
                                            <small class="text-muted">{{__('app.status')}}</small>
                                            <div>
                                                @if($career->status == "open")
                                                <span class="badge bg-success rounded-pill">{{ $career->status }}</span>
                                                @else
                                                <span class="badge bg-danger rounded-pill">{{ $career->status }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">{{__('app.created at')}}</small>
                                            <div class="fw-bold">{{$career->created_at->diffForHumans()}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="applications" class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="fw-bold mb-0">{{__('app.applications')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="applicationsAccordion">
                                    @forelse ($career->applications as $application)
                                    <div class="accordion-item border-0 mb-3">
                                        <h2 class="accordion-header" id="heading-{{ $application->id }}">
                                            <button class="accordion-button collapsed rounded-3 shadow-sm" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#application-{{ $application->id }}"
                                                aria-expanded="true" aria-controls="application-{{ $application->id }}">
                                                <div>
                                                    <strong>{{ $application->name }}</strong>
                                                    <div class="text-muted small">
                                                        {{ $application->created_at->diffForHumans() }}</div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="application-{{ $application->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $application->id }}"
                                            data-bs-parent="#applicationsAccordion">
                                            <div class="accordion-body bg-light rounded-3 mt-2 p-4">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <small class="text-muted">Email</small>
                                                        <div class="fw-bold">{{ $application->email }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <small class="text-muted">Phone</small>
                                                        <div class="fw-bold">{{ $application->phone }}</div>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <small class="text-muted">Cover Letter</small>
                                                        <div class="mt-2">{{ $application->cover_letter }}</div>
                                                    </div>

                                                    {{-- CV Download --}}
                                                    @if($application->cv_path)
                                                    <div class="col-12 mt-3">
                                                        <a href="{{ asset('storage/' . $application->cv_path) }}"
                                                            class="btn btn-primary btn-sm" download>
                                                            <i class="fa fa-download"></i> تحميل السيرة الذاتية
                                                        </a>
                                                    </div>
                                                    @endif

                                                    {{-- AI Rating --}}
                                                    @if($application->ai_rate)
                                                    <div class="col-12 mt-3">
                                                        <small class="text-muted">AI Rating</small>
                                                        <div class="fw-bold text-success">
                                                            {{ $application->ai_rate }} / 100
                                                        </div>
                                                    </div>
                                                    @endif

                                                    {{-- AI Summary --}}
                                                    @if($application->ai_summary)
                                                    <div class="col-12 mt-3">
                                                        <small class="text-muted">AI Summary</small>
                                                        <div class="text-muted">
                                                            {{ $application->ai_summary }}
                                                        </div>
                                                    </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center text-muted py-4">
                                        <i class="fa fa-inbox fa-2x mb-3"></i>
                                        <p>{{ __("app.no applications yet") }}</p>
                                    </div>
                                    @endforelse
                                </div>

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
<script>

</script>
@endsection