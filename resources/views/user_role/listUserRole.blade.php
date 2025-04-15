@extends("layouts.master")
@section("title")
{{ __("app.user role") }}
@endsection

@section("css")
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<style>
  .action-icons {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .action-icon {
    font-size: 18px;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;
    background: none;
    border: none;
  }

  .action-icon.edit {
    color: #28a745;
  }

  .action-icon.delete {
    color: #dc3545;
  }

  .action-icon:hover {
    opacity: 0.8;
    transform: scale(1.1);
  }

  .btn-create {
    background-color: #1da1f2;
    border-color: #1da1f2;
    color: white;
  }

  .btn-create i {
    margin-right: 5px;
  }

  .btn-create:hover {
    background-color: #0d8ecf;
    border-color: #0d8ecf;
  }
</style>
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
      <section id="ordering">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("app.user role") }}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    @can('role create_and_view')
                    <li>
                      <a class="btn btn-create" href="{{ route('userRole.create') }}">
                        <i class="la la-plus"></i> {{ __('project.create') }}
                      </a>
                    </li>
                    @endcan
                  </ul>
                </div>
              </div>

              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <table class="table table-striped table-bordered default-ordering dataTable" id="DataTables_Table_1"
                      role="grid" aria-describedby="DataTables_Table_1_info">
                      <thead>
                        <tr role="row">
                          <th>#</th>
                          <th>{{ __("project.name") }}</th>
                          <th>{{ __('project.permissions') }}</th>
                          <th>{{ __("project.created_at") }}</th>
                          <th class="no-sorting">{{ __("project.action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($roles as $role)
                        <tr role="row" class="odd">
                          <td>{{ $role->id }}</td>
                          <td>{{ $role->name }}</td>
                          <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                          <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y') }}</td>
                          <td class="action-icons">
                            @can("role update")
                            <a class="action-icon edit" href="{{ route('userRole.edit', $role->id) }}" title="{{ __('project.edit') }}">
                              <i class="la la-pencil"></i>
                            </a>
                            @endcan

                            @if ($role->id != 1)
                            @can('role delete')
                            <form action="{{ route('userRole.destroy', $role->id) }}" method="post" style="display:inline;">
                              @csrf
                              @method('delete')
                              <button type="submit" class="action-icon delete confirm-button" title="{{ __('project.delete') }}">
                                <i class="la la-trash"></i>
                              </button>
                            </form>
                            @endcan
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

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
<script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-basic.js') }}" type="text/javascript"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.no-sorting').removeClass('sorting_desc');

    $('#DataTables_Table_1').on('click', '.confirm-button', async function (event) {
      var form = $(this).closest("form");
      event.preventDefault();
      try {
        const firstConfirm = await Swal.fire({
          title: "{{ __('project.delete_question') }}",
          text: "{{ __('project.delete_warn') }}",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: "{{ __('project.deletey_yes') }}",
          cancelButtonText: "{{ __('project.deletey_no') }}"
        });

        if (firstConfirm.isConfirmed) {
          const secondConfirm = await Swal.fire({
            title: "{{ __('project.delete_question') }}",
            input: 'text',
            inputLabel: "{{ __('project.delete_enter_confirm') }}",
            inputPlaceholder: 'confirm',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "{{ __('project.submit') }}",
            cancelButtonText: "{{ __('project.cancel') }}"
          });

          if (secondConfirm.isConfirmed && secondConfirm.value == 'confirm') {
            form.submit();
          } else {
            Swal.fire({
              title: "{{ __('project.cancel') }}",
              text: "{{ __('project.delete_confirm_notvalid') }}",
              icon: 'info'
            });
          }
        } else {
          Swal.fire({
            title: "{{ __('project.cancel') }}",
            text: "{{ __('project.cancel_message') }}",
            icon: 'info'
          });
        }
      } catch (error) {
        console.error("{{ __('project.delete_error') }}", error);
        Swal.fire({
          title: "{{ __('project.error') }}",
          text: "{{ __('project.error_message') }}",
          icon: 'error'
        });
      }
    });
  });
</script>
@endsection
