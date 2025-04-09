@extends("layouts.master")

@section("title", "Attendance Management")

@section("css")
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .card {
        background-color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
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

    .card .header button {
        background: none;
        border: none;
        color: #3498db;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .card .header button:hover {
        color: #2980b9;
    }

    .card .body {
        margin-bottom: 20px;
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
    }

    .card .footer .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    .btn-warning {
        background-color: #f1c40f;
        border-color: #f1c40f;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #f39c12;
        border-color: #f39c12;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    .add-career-btn {
        display: inline-block;
        padding: 12px 24px;
        background-color: #2ecc71;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 30px;
        transition: background-color 0.3s ease;
    }

    .add-career-btn:hover {
        background-color: #27ae60;
        text-decoration: none;
        color: white;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="basic-form-layouts">
                <div>
                    <a href="{{ route("careers.create") }}" class="add-career-btn">
                        <i class="fa fa-plus-circle"></i> {{ __('app.add new career') }}
                    </a>
                </div>

                <div class="row">
                    @forelse($careers as $career )
                    <div class="col-md-4 col-lg-4">
                        <div class="card">
                            <div class="header">
                                <div>
                                    {{ $career->title }}
                                </div>
                                @if($career->status == "open")
                                <span class="badge rounded fs-6  p-1 text-bg-success">{{ $career->status }}</span>

                                @else
                                <span class="badge rounded fs-6  p-1  text-bg-danger">{{ $career->status }}</span>
                                @endif
                            </div>

                            <div class="body">
                                <p>
                                    <i class="fa fa-clock"></i>
                                    {{ $career->created_at->diffForHumans() }}
                                </p>
                                <p>
                                    <i class="fa fa-building"></i>
                                    {{ $career->department->name }}
                                </p>
                                <p>
                                    {{ Str::limit($career->description, 300, __("app.more")) }}
                                </p>
                            </div>

                            <div class="footer">
                                <a href="{{ route('careers.show', $career->id) }}" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('careers.edit', $career->id) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('careers.destroy', $career->id) }}" method="POST"
                                    style="display:inline;" id="deleteCareer">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
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
                        @endforelse
                    </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section("js")

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $("#deleteCareer").submit(function(e) {
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
   
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire({
      title: "Cancelled",
      text: "Your imaginary file is safe :)",
      icon: "error"
    });
  }
});

    });
    });
  
</script>
@endsection