@extends("back.layouts.master")
@section("title")
{{__("project.user role list")}}
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
     
        <section id="ordering">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> {{__("project.user role list")}}</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      @can('role create_and_view')
                      <li><a  class="btn btn-success text-white" href="{{route('admin.userRole.create')}}">{{__('project.create')}}</a></li>
                        
                      @endcan
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard">
                  
                    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                      
                        <table class="table table-striped table-bordered default-ordering dataTable" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;" aria-sort="descending">#</th>
                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 88.3375px;">{{__("project.name")}}</th>
                        
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;" aria-sort="descending">{{__('project.permissions')}}</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;" aria-sort="descending">{{__("project.created_at")}}</th>
                          <th class="no-sorting" tabindex="0"
                           aria-controls="DataTables_Table_1" rowspan="1" colspan="1" 
                           aria-label="Position: activate to sort column ascending" 
                           style="width: 88.3375px;">{{__("project.action")}}</th>
                        </tr>
                      </thead>
                      <tbody>
                      

                      
                        @foreach ($roles as $role)
                        <tr role="row" class="odd">

                        <td class="">{{$role->id}}</td>
                        <td class="">{{$role->name}}</td>
                        <td class="">{{$role->permissions->pluck('name')->implode(', ')}}</td>
                        <td class="">{{ Carbon\Carbon::parse( $role->created_at)->format('d/m/Y')}}</td>
                        

                        
                        <td class="d-flex ">
                             
@can("role update")
<a  class="btn btn-success mx-2"href="{{route('admin.userRole.edit', $role->id)}}"><i class="la la-pencil" data-toggle="tooltip" data-placement="top"  title="{{__("project.edit")}}"></i></a>
@endcan
@if($role->id!=1)
@can('role delete')
<form action="{{route('admin.userRole.destroy',  $role->id)}}" method="post">                     
  @csrf
  @method('delete')
  <button   type="submit"  class="btn btn-danger confirm-button" ><i class="la la-trash" title="{{__("project.delete")}}"data-toggle="tooltip" data-placement="top" ></i></button>
</form>
@endcan

@endif
                            

                          
                        </td>

                          
                      </tr>
                        @endforeach
                          
                       </tbody>
                     
                    </table></div></div>
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
<script src="{{asset('app-assets/js/scripts/tables/datatables/datatable-basic.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

$(document).ready(function(){
$('.no-sorting').removeClass('sorting_desc');


$('#DataTables_Table_1').on('click','.confirm-button', async function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        try {
                // First confirmation
                const firstConfirm = await Swal.fire({
                    title: "{{__('project.delete_question')}}",
                    text:"{{__('project.delete_warn')}}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{__('project.deletey_yes')}}",
                    cancelButtonText: "{{__('project.deletey_no')}}"
                });

                if (firstConfirm.isConfirmed) {
                    // Second confirmation with input field
                    const secondConfirm = await Swal.fire({
                        title: "{{__('project.delete_question')}}",
                        input: 'text',
                        inputLabel: "{{__('project.delete_enter_confirm')}}",
                        inputPlaceholder: 'confirm',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText:  "{{__('project.submit')}}",
                        cancelButtonText:"{{__('project.cancel')}}"
                    });

                    if (secondConfirm.isConfirmed && secondConfirm.value =='confirm') {
                        // Handle the confirmed value
                        const inputValue = secondConfirm.value;
                        form.submit();
                        
                    } else {
                        // Handle cancellation of the second prompt
                        Swal.fire({
                            title: "{{__('project.cancel')}}",
                            text: "{{__('project.delete_confirm_notvalid')}}",
                            icon: 'info'
                        });
                    }
                } else {
                    // Handle cancellation of the first prompt
                    Swal.fire({
                        title: "{{__('project.cancel')}}",
                        text: "{{__('project.cancel_message')}}",
                        icon: 'info'
                    });
                }
            } catch (error) {
                console.error("{{__('project.delete_error')}}", error);
                Swal.fire({
                    title: "{{__('project.error')}}",
                    text: "{{__('project.error_message')}}",
                    icon: 'error'
                });
            }
    });

    });

</script>

@endsection

