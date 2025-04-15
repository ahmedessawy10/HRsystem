@extends("layouts.master")

@section("title", "Career Management")

@section("css")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .card {
        background-color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
        height: 100%;
    }

    .card:hover {
        transform: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card .header div {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .card .body p {
        margin-bottom: 12px;
        color: #555;
        line-height: 1.6;
    }

    .card .footer {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-left: 20px;
    }

    .card .footer .btn {
        background: none !important;
        border: none !important;
        padding: 0;
        font-size: 18px;
    }

    /* Soft colors for icons */
    .btn-primary .fa {
        color: #70d4f7;
    }

    .btn-primary:hover .fa {
        color: #36c4f0;
    }

    .btn-warning .fa {
        color: #f7d774;
    }

    .btn-warning:hover .fa {
        color: #f5c543;
    }

    .btn-danger .fa {
        color: #f49b9b;
    }

    .btn-danger:hover .fa {
        color: #ec6e6e;
    }

    .add-career-btn {
        display: inline-block;
        padding: 12px 24px;
        background-color: #0ccaf0;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 30px;
        transition: background-color 0.3s ease;
    }

    .add-career-btn:hover {
        background-color: #00a3e0;
        text-decoration: none;
        color: white;
    }

    .status-icon {
        font-size: 1.3rem;
        font-weight: bold;
    }

    .status-icon.text-success {
        color: #0ccaf0;
    }

    .status-icon.text-danger {
        color: #e74c3c;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <section id="basic-form-layouts">
                <div>
                    <a href="{{ route("careers.create") }}" class="add-career-btn">
                        <i class="fa fa-plus-circle"></i> {{ __('app.add new career') }}
                    </a>
                </div>

                <div class="row">
                    @forelse($careers as $career)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="header">
                                <div>{{ $career->title }}</div>

                                @if($career->status == "open")
                                <i class="bi bi-check-circle-fill status-icon text-success">{{ $career->status }}</i>
                                @else
                                <i class="bi bi-x-circle-fill status-icon text-danger">{{ $career->status }}</i>
                                @endif
                            </div>

                            <div class="body">
                                <p><i class="fa fa-clock"></i> {{ $career->created_at->diffForHumans() }}</p>
                                <p><i class="fa fa-building"></i> {{ $career->department->name }}</p>
                                <p>{{ Str::limit($career->description, 300, __("app.more")) }}</p>
                            </div>

                            <div class="footer">
                                <a href="{{ route('careers.show', $career->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('careers.edit', $career->id) }}" class="btn btn-warning" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('careers.destroy', $career->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            <strong>{{ __('app.no careers found') }}</strong>
                        </div>
                    </div>
                    @endforelse
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
        // Init Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Delete confirmation
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
