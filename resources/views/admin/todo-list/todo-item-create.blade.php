<div class="modal-header">
    <h4 class="modal-title">@lang('modules.module.todos.createTodoItem')</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="createTodoItem" class="ajax-form" method="POST" autocomplete="off">
        @csrf
        <div class="form-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>@lang('modules.module.todos.form.title')</label>

                        <input type="text" class="form-control form-control-lg" id="title" name="title">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="create-todo-item" class="btn btn-success">@lang('app.create') <i class="fa fa-arrow-right"></i></button>
        </div>
    </form>
</div>
