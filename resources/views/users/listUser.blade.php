@extends("layouts.master")
@section("title")
{{__("project.users")}}
@endsection
@section("css")
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
  integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .bootstrap-switch-handle-off {
    background-color: #ff394f !important;
    color: white !important;
    padding-right: 5px !important;
    padding-left: 5px !important;
  }
</style>
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
                <h4 class="card-title"> {{__("project.users")}} </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    @can('user create_and_view')
                    <li><a class="btn btn-success text-white"
                        href="{{route('users.create')}}">{{__("project.create")}}</a></li>
                    @endcan

                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">

                  <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                    <table class="table table-striped table-bordered zero-configuration dataTable"
                      id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                      <thead>
                        <tr role="row">
                          <th class="w-10 sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                            colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;"
                            aria-sort="descending">#</th>
                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            aria-label="Position: activate to sort column ascending" style="width: 88.3375px;">
                            {{__("project.name")}}</th>

                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                            colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;"
                            aria-sort="descending">{{__("project.email")}}</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                            colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;"
                            aria-sort="descending">{{__("project.roles")}}</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                            colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;"
                            aria-sort="descending">{{__("project.status")}}</th>
                          <th class="sorting_desc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                            colspan="1" aria-label="Name: activate to sort column ascending" style="width: 69.4875px;"
                            aria-sort="descending">{{__("project.created_at")}}</th>
                          <th class="no-sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                            aria-label="Position: activate to sort column ascending" style="width: 88.3375px;">
                            {{__("project.action")}}</th>
                        </tr>
                      </thead>
                      <tbody>



                        @foreach ($users as $user)
                        <tr role="row" class="odd">
                          <td class="">{{$user->id}}</td>
                          <td class="">{{$user->name}}</td>
                          <td class="">{{$user->email}}</td>
                          <td class=""> <span
                              class="badge badge-success badge-pill">{{$user->roles->pluck('name')->implode(' , ')}}</span>
                          </td>
                          <td>
                            <div class="float-left">
                              @if($user->id !=1)

                              <input type="checkbox" class="make-switch switchBootstrap" data-id="{{$user->id}}"
                                data-on-text="{{__('project.active')}}" data-off-text="{{__('project.inactive')}}"
                                @if($user->status == 'active')
                              checked="checked"
                              @endif
                              />

                            </div>
                            @else
                            <div class="btn " style="background-color:#337ab7;color:white;">{{__('project.active')}}
                            </div>
                            @endif
                          </td>
                          <td class="">{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}</td>

                          <td class="d-flex">
                            @can('user update')
                            @if ( $user->id==1 )
                            @if (auth()->id()==1)
                            <a class="btn btn-success mx-1" href="{{route('users.edit',$user->id)}}">
                              <i class="la la-pencil" data-toggle="tooltip" data-placement="top"
                                title="{{__("project.edit")}}"></i>
                            </a>
                            @endif
                            @else
                            <a class="btn btn-success mx-1" href="{{route('users.edit',$user->id)}}">
                              <i class="la la-pencil" data-toggle="tooltip" data-placement="top"
                                title="{{__("project.edit")}}"></i>
                            </a>
                            @endif

                            @endcan

                            @can('user delete')
                            @if($user->id!=1)
                            <form action="{{route('users.destroy', $user->id)}}" method="post">
                              @csrf
                              @method('delete')
                              <button type="submit" class="btn btn-danger confirm-button">
                                <i class="la la-trash" title="{{__("project.delete")}}" data-toggle="tooltip"
                                  data-placement="top"></i></button>
                            </form>
                            @endif
                            @endcan

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
<script src="{{asset('app-assets/js/scripts/tables/datatables/datatable-basic.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
  $(document).ready(function(){

  var table = $('.table').DataTable();


  function initBootstrapSwitch() {
        $(".switchBootstrap").bootstrapSwitch();
    }

    initBootstrapSwitch();

    table.on('draw', function() {
        initBootstrapSwitch();
    });

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
   

$(document).on('switchChange.bootstrapSwitch', '.switchBootstrap', function(event, state)  { 
           
      var status = $(this).prop('checked') == true ? 1 : 0;  
      var user_id = $(this).data('id');  
           $.ajax({ 
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "POST", 
               dataType: "json", 
               url: '{{route('users.active')}}', 
               data: {'status': status, 'user_id':user_id}, 
               success: function(data){ 
                if(data.success){
                  toastr.options.timeOut = 4000;
                  toastr.success(data.success);
                  console.log('true');
                }else{
                  console.log(state);
                  toastr.error(data.error);
                  $(this).bootstrapSwitch('state',!status,true);
                  
                }    
            } 
         }); 
      }) ;

    });


  
</script>

@endsection