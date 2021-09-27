<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="card-title">
        @lang('modules.module.todos.todoList')
    </h3>
    <a href="{{ route('admin.todo-items.index') }}" class="btn btn-sm btn-custom">
        @lang('modules.module.todos.viewAll')
    </a>
</div>

<div id="upper-box" class="todo-box mb-3">
    <div class="todo-title">
        <h5>@lang('modules.module.todos.pendingTasks')</h5>
        <a href="javascript:showNewTodoForm();" class="btn btn-sm btn-add"><i class="fa fa-plus"></i></a>
    </div>
    <ul class="list-group px-3 py-2" id="pending-tasks">
        @forelse ($pendingTodos as $todo)
            <li data-id="{{ $todo->id }}" data-position="{{ $todo->position }}" class="draggable list-group-item">
                {{--<div class="handle">--}}
                    {{--<i class="fa fa-bars"></i>--}}
                {{--</div>--}}
                <div class="d-flex">
                    <span class="mb-2">
                        <input data-id="{{ $todo->id }}" type="checkbox" name="status" id="status-{{ $todo->id }}">
                        <label for="status-{{ $todo->id }}">{{ $todo->title }}</label>
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <p class="mb-0">{{ $todo->created_at->format('Y-m-d') }}</p>
                    <div class="text-right">
                        <a href="javascript:showUpdateTodoForm('{{ $todo->id }}');" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i></a>
                        <a href="javascript:deleteTodoItem('{{ $todo->id }}');" class="btn btn-delete"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            </li>
        @empty
            <li class="list-group-item" id="no-pending-task">
                <h6 class="card-title">
                    @lang('modules.module.todos.noPendingTasks')
                </h6>
            </li>
        @endforelse
    </ul>
</div>
<div id="lower-box" class="todo-box">
    <div class="todo-title">
        <h5>@lang('modules.module.todos.completedTasks')</h5>
    </div>
    <ul class="list-group px-3 py-2" id="completed-tasks">
        @forelse ($completedTodos as $todo)
            <li data-id="{{ $todo->id }}" data-position="{{ $todo->position }}" class="draggable list-group-item">
                {{--<div class="handle">--}}
                    {{--<i class="fa fa-bars"></i>--}}
                {{--</div>--}}
                <div class="d-flex">
                    <span class="mb-2">
                        <input data-id="{{ $todo->id }}" checked type="checkbox" name="status" id="status-{{ $todo->id }}">
                        <label for="status-{{ $todo->id }}">{{ $todo->title }}</label>
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <p class="mb-0">{{ $todo->created_at->format('Y-m-d') }}</p>
                    <div class="text-right">
                        <a href="javascript:showUpdateTodoForm('{{ $todo->id }}');" class="btn btn-edit"><i class="fa fa-pencil-square-o"></i></a>
                        <a href="javascript:deleteTodoItem('{{ $todo->id }}');" class="btn btn-delete"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            </li>
        @empty
            <li class="list-group-item" id="no-completed-task">
                <h6 class="card-title">
                    @lang('modules.module.todos.noCompletedTasks')
                </h6>
            </li>
        @endforelse
    </ul>
</div>

