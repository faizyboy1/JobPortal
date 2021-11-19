@extends('layouts.app')

@push('head-script')
<style>
    .list-group-item{
        background-color: #f6f7fb;
        margin: 5px;
        border-radius: 0 !important;
        border: 0;
        padding: 5px;
        padding-left: 30px;
    }

    .list-group-item p {
        font-size: 12px;
        padding-left: 20px;
    }

    .list-group-item .btn{
        font-size: 13px;
        display: inline-block;
        padding: 0 5px;
        color: var(--main-color);
    }
</style>
    
@endpush
@section('content')
    <div class="row justify-content-between">
        <a href="{{ url ('/candidate/resume/'.auth()->user()->id.'/edit') }}" class="btn btn-success py-2"
        style="padding:  0 2rem;
        background-color: #1579d0;
        color: #fff;
        border-color:#1579d0;
        box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
         type="button" id="add-more">
            Update
        </a>
        <a class="btn btn-success py-2"
        style="padding:  0 2rem;
        background-color: #1579d0;
        color: #fff;
        border-color:#1579d0;
        box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
         type="button" id="add-more">
            Download
        </a>
    </div>    
    <div class="container bg-white card">
        <div class="row d-flex p-4">
            @if ($candidateResume->profile_picture)
            <div class="">
                {{-- <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80" class="rounded-circle" width="150px" height="150px"  alt="profilePic"> --}}
                <img src="/storage/{{ $candidateResume->profile_picture }}" class="rounded-circle" width="150px" height="150px"  alt="profilePic">
            </div>
            @endif

            <div style="margin-left: 95px" class="flex-grow-1">
                <div style="border-bottom-width: 4px!important" class="candidateName pb-3 border border-top-0 border-right-0 border-left-0 border-primary">
                    <h2 class="candidateName__name"> <span class="text-primary">{{ $candidateResume->first_name }}</span> <span>{{ $candidateResume->last_name }}</span> </h2>
                </div>
            
                <div class="mt-4  d-flex justify-content-between">
                    <p class="basicInformation__address">
                        <span>{{ $candidateResume->address }}</span><br>
                        <span>{{ $candidateResume->state }}</span>-<span>{{ $candidateResume->zip_code }}</span><br>
                        <span>{{ $candidateResume->country }}</span>
                    </p>
                    <div class="basicInformation__Eaddress">
                        <div class="d-flex">
                            <span class=" mr-4 font-weight-bold text-primary">
                                E-mail:  
                            </span>
                            <p>{{ $candidateResume->email }}</p>
                        </div>
                        <div class="d-flex" >
                            <span class=" mr-4 font-weight-bold text-primary">Phone:</span>
                            <span>{{ $candidateResume->country_code }} </span>
                            <p>{{ $candidateResume->phone }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">LANGUAGES</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                @foreach ($languages as $language)
                     <p>{{ $language->language }}</p>
                @endforeach
            </div>
        </div>
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">SKILLS</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                @foreach ($skills as $skill )
                    
                <p>{{ $skill->skill }}</p>
                @endforeach
            </div>
        </div>
        @if ($candidateResume->objective)
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">OBJECTIVE</p>
            </div>
            <div style="margin-left: 45px;" class="flex-grow-1">
                <p>{{ $candidateResume->objective }}</p>
            </div>
        </div>
        @endif
        
        <div class="row d-flex p-4">
            <div  class=" ">
                <p  style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">EDUCATION</p>
            </div>
            <div class="d-flex flex-column flex-grow-1 ">
                @foreach ($educations as $education )
                
                <div style="margin-left: 45px;color:black!important" class=" text-black">
                    <div class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $education->degree }}</h4>
                        <h4>{{ $education->year }}</h4>
                    </div>
                    <p>{{ $education->institute }}</p>
                </div>
                @endforeach
            </div>
            
        </div>
        @if ($experiences)
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">WORK EXPERIENCE</p>
            </div>
            <div class="flex-grow-1">
                @foreach ($experiences as $experience)
                
                <div style="margin-left: 45px;" >
                    <div style="color:black!important" class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $experience->company_name }}</h4>
                        <h4> <span>{{$experience->start_date  }}</span>/<span>{{ $experience->present ==="Present" ? $experience->present : $experience->end_date }}</span></h4>
                    </div>
                    <p>{{ $experience->job_title }}</p>
                    <p>{{ $experience->job_description }}</p>
                </div>
            @endforeach
            </div>
            
        </div>
        @endif
        @if ($certifications)
        <div class="row d-flex p-4">
            <div  class="">
                <p style="width:200px;border-bottom-width: 4px!important" class=" border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">CERTIFICATION</p>
            </div>
            <div class="flex-grow-1">
                @foreach ( $certifications as $certification )
            <div style="margin-left: 45px;" >
                <div style="color:black!important"  class="d-flex justify-content-between font-weight-bold">
                    <h4>{{ $certification->certification_name }}</h4>
                    <h4>{{ $certification->certification_year }}</h4>
                </div>
                <p>{{ $certification->certification_institute }}</p>    
            </div>
            @endforeach
            </div>
            
            
        </div>
        @endif
        @if ($awards)
        <div class="row d-flex p-4">
            <div  class=" ">
                <p style="width:200px;border-bottom-width: 4px!important" class="border border-top-0 border-right-0 border-left-0 border-primary font-weight-bold text-primary">AWARDS</p>
            </div>
            <div class="flex-grow-1">
                @foreach ($awards as $award )
                <div style="margin-left: 45px;" >
                    <div style="color:black!important"  class="d-flex justify-content-between font-weight-bold">
                        <h4>{{ $award->award_name }}</h4>
                        <h4>{{ $award->award_year }}</h4>
                    </div>
                    <p>{{ $award->award_institute }}</p>   
                </div>
                @endforeach
            </div>
            
        </div>
        @endif
        

        
        
    </div>

@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>

    <script>
        var updated = true;

        function showNewTodoForm() {
            let url = "{{ route('admin.todo-items.create') }}"

            $.ajaxModal('#application-md-modal', url);
        }

        function initSortable() {
            let updates = {'pending-tasks': false, 'completed-tasks': false};
            let completedFirstPosition = $('#completed-tasks').find('li.draggable').first().data('position');
            let pendingFirstPosition = $('#pending-tasks').find('li.draggable').first().data('position');

            $('#pending-tasks').sortable({
                connectWith: '#completed-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true)
                    {
                        const inverseIndex =  completedFirstPosition > 0 ? completedFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;

                        updateTodoItem(id, position={oldPosition, newPosition}, status='completed');

                    }
                    else if(updates['pending-tasks']===true && updates['completed-tasks']===false)
                    {
                        const newPosition = pendingFirstPosition - ui.item.index();

                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();

            $('#completed-tasks').sortable({
                connectWith: '#pending-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true)
                    {
                        const inverseIndex =  pendingFirstPosition > 0 ? pendingFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;

                        updateTodoItem(id, position={oldPosition, newPosition}, status='pending');
                    }
                    else if(updates['pending-tasks']===false && updates['completed-tasks']===true)
                    {
                        const newPosition = completedFirstPosition - ui.item.index();

                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();
        }
        function updateTodoItem(id, pos, status=null) {
            let data = {
                _token: '{{ csrf_token() }}',
                id: id,
                position: pos,
            };

            if (status) {
                data = {...data, status: status}
            }

            $.easyAjax({
                url: "{{ route('admin.todo-items.updateTodoItem') }}",
                type: 'POST',
                data: data,
                container: '#todo-items-list',
                success: function (response) {
                    $('#todo-items-list').html(response.view);
                    initSortable();
                }
            });
        }

        function showUpdateTodoForm(id) {
            let url = "{{ route('admin.todo-items.edit', ':id') }}"
            url = url.replace(':id', id);

            $.ajaxModal('#application-md-modal', url);
        }

        function deleteTodoItem(id) {
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    let url = "{{ route('admin.todo-items.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    let data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    }

                    $.easyAjax({
                        url,
                        data,
                        type: 'POST',
                        container: '#roleMemberTable',
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#todo-items-list').html(response.view);
                                initSortable();
                            }
                        }
                    })
                }
            });
        }

        @if ($user->roles->count() > 0)
            $('#todo-items-list').html(``);
        @endif

        initSortable();

        $('body').on('click', '#create-todo-item', function () {
            $.easyAjax({
                url: "{{route('admin.todo-items.store')}}",
                container: '#createTodoItem',
                type: "POST",
                data: $('#createTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('click', '#update-todo-item', function () {
            const id = $(this).data('id');
            let url = "{{route('admin.todo-items.update', ':id')}}"
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                container: '#editTodoItem',
                type: "POST",
                data: $('#editTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('change', '#todo-items-list input[name="status"]', function () {
            const id = $(this).data('id');
            let status = 'pending';

            if ($(this).is(':checked')) {
                status = 'completed';
            }

            updateTodoItem(id, null, status);
        })

        $(document).ready(function(){
           $("#submit-form").submit(function (event){

            $.easyAjax({
                url : "candidate.resume",
                type : "POST",
                data : $("$submit-form").serializeArray(),
                success : function(data){
                    alert("Success");
                }
            });
           });
        });
        
    </script>
@endpush