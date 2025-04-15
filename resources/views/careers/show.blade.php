@extends("layouts.master")

@section("title", "Career Details")

@section("css")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f0f3f7;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background: linear-gradient(90deg, #f0f3f7, #0ccaf0);
        color: white;
        text-align: center;
        border-radius: 16px 16px 0 0;
        padding: 2rem;
    }

    .card-header h4, .card-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #0ccaf0;
        box-shadow: 0 0 0 0.25rem rgba(0, 114, 255, 0.25);
    }

    .btn-primary {
        background-color: #f0f3f7;
        border-color: #0ccaf0;
        border-radius: 8px;
    }

    .btn-primary:hover {
        background-color: #0ccaf0;
    }

    .icon-button {
        background: none;
        border: none;
        color: #0ccaf0;
        cursor: pointer;
        transition: color 0.3s ease;
        position: relative;
        font-size: 1.2rem;
    }

    .icon-button:hover {
        color: #0ccaf0;
    }

    .icon-button[data-tooltip="Edit"] {
        color: #ffc107;
    }

    .icon-button[data-tooltip="Delete"] {
        color: #dc3545;
    }

    .icon-button:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 10;
    }

    .status-icon {
        font-size: 1.3rem;
        font-weight: bold;
        margin-right: 6px;
        vertical-align: middle;
    }

    .status-icon.text-success {
        color: #28a745;
    }

    .status-icon.text-danger {
        color: #dc3545;
    }

    .accordion-button {
        background-color: #f9fbfd;
        border: 1px solid #e0e6ed;
        font-weight: 600;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease-in-out;
    }

    .accordion-button:not(.collapsed) {
        background-color: #e6f0ff;
        color: #0ccaf0;
        border-color: #b3d4fc;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-body {
        background-color: #ffffff;
        border: 1px solid #e0e6ed;
        border-top: none;
        border-radius: 0 0 10px 10px;
        padding: 2rem;
    }

    .accordion-item {
        background-color: transparent;
        border: none;
    }

    .application-meta {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .application-title {
        font-size: 1rem;
        font-weight: 600;
    }

    /* Force show for debugging if needed */
    .dropdown-menu.show {
        display: block;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $career->title }}</h4>
                            </div>
                            <div class="card-body">
                                <h5 class="text-primary">{{ __('app.job description') }}</h5>
                                <p class="text-muted">{{ $career->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('app.career details') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end mb-3 gap-2">
                                    <a href="{{ route('careers.edit', $career->id) }}" class="icon-button" data-tooltip="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('careers.destroy', $career->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button" data-tooltip="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="career-details">
                                    <div class="mb-3">
                                        <small class="text-muted">{{ __('app.department') }}</small>
                                        <div class="fw-bold">{{ $career->department->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">{{ __('app.status') }}</small>
                                        <div>
                                            @if($career->status == "open")
                                            <i class="bi bi-check-circle-fill status-icon text-success">{{ $career->status }}</i>
                                            @else
                                            <i class="bi bi-x-circle-fill status-icon text-danger">{{ $career->status }}</i>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">{{ __('app.created at') }}</small>
                                        <div class="fw-bold">{{ $career->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- <section id="applications" class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5>{{ __('app.applications') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="applicationsAccordion">
                                    @forelse ($career->applications as $application)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $application->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#application-{{ $application->id }}" aria-expanded="false">
                                                <div>
                                                    <span class="application-title">{{ $application->name }}</span>
                                                    <div class="application-meta">{{ $application->created_at->diffForHumans() }}</div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="application-{{ $application->id }}" class="accordion-collapse collapse" data-bs-parent="#applicationsAccordion">
                                            <div class="accordion-body">
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
                                                        <div>{{ $application->cover_letter }}</div>
                                                    </div>
                                                    @if($application->cv_path)
                                                    <div class="col-12 mt-3">
                                                        <a href="{{ asset('storage/' . $application->cv_path) }}" class="btn btn-primary btn-sm" download>
                                                            <i class="fa fa-download"></i> Download CV
                                                        </a>
                                                    </div>
                                                    @endif
                                                    @if($application->ai_rating)
                                                    <div class="col-12 mt-3">
                                                        <small class="text-muted">AI Rating</small>
                                                        <div class="fw-bold text-success">
                                                            {{ $application->ai_rate }} / 100
                                                        </div>
                                                    </div>
                                                    @endif
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
            </section> -->

            <section id="applications" class="mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('app.applications') }}</h5>
                </div>
                <div class="card-body">
                    @forelse ($career->applications as $application)
                        <div class="border-bottom py-2">
                            <a href="#" 
                               class="application-title text-primary fw-bold text-decoration-none" 
                               data-bs-toggle="modal" 
                               data-bs-target="#applicationModal-{{ $application->id }}">
                                {{ $application->name }}
                            </a>
                            <div class="application-meta text-muted small">
                                {{ $application->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="applicationModal-{{ $application->id }}" tabindex="-1" aria-labelledby="applicationModalLabel-{{ $application->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="applicationModalLabel-{{ $application->id }}">{{ $application->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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
                                                <div>{{ $application->cover_letter }}</div>
                                            </div>
                                            @if($application->cv_path)
                                            <div class="col-12 mt-3">
                                                <a href="{{ asset('storage/' . $application->cv_path) }}" class="btn btn-primary btn-sm" download>
                                                    <i class="fa fa-download"></i> Download CV
                                                </a>
                                            </div>
                                            @endif
                                            @if($application->ai_rating)
                                            <div class="col-12 mt-3">
                                                <small class="text-muted">AI Rating</small>
                                                <div class="fw-bold text-success">
                                                    {{ $application->ai_rating }} / 5
                                                </div>
                                            </div>
                                            @endif
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
</section>

        </div>
    </div>
</div>
@endsection

@section("js")
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        setTimeout(() => {
                            e.target.submit();
                        }, 1500);
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
