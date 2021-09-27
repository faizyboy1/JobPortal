<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\TodoItem;
use Illuminate\Http\Request;

class AdminTodoItemController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-speedometer';
        $this->pageTitle = 'menu.todoList';
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of($this->user->todoItems)
            ->addColumn('action', function ($row) {
                $action = '<a href="javascript:showUpdateTodoForm(' . $row->id . ');" class="btn btn-primary btn-circle edit-todo" data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <a href="javascript:deleteTodoItem(' . $row->id . ');" class="btn btn-danger btn-circle delete-todo" data-toggle="tooltip" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

                return $action;
            })
            ->editColumn('title', function ($row) {
                return ucfirst($row->title);
            })
            ->editColumn('status', function ($row) {
                $pendingSelected = $row->status == 'pending' ? 'selected' : '';
                $completedSelected = $row->status == 'completed' ? 'selected' : '';

                return '<select name="status" id="status-'. $row->id . '" class="form-control" data-title="' . $row->title . '" onchange="javascript:updateTodoStatus(' . $row->id . ');">
                    <option ' . $pendingSelected . ' value="pending">' . __('modules.module.todos.pending') . '</option>
                    <option ' . $completedSelected . ' value="completed">' . __('modules.module.todos.completed') . '</option>
                </select>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->toJson();
        }
        return view('admin.todo-list.index', $this->data);
    }

    public function create(Request $request)
    {
        return view('admin.todo-list.todo-item-create');
    }

    public function edit(Request $request, $id)
    {
        $todoItem = $this->user->todoItems()->where('id', $id)->firstOrFail();

        return view('admin.todo-list.todo-item-edit', compact('todoItem'));
    }

    public function store(Request $request)
    {
        $todos = $this->todoItems->filter(function ($value, $key) {
            return $value->status == 'pending';
        });
        $todoItem = new TodoItem();

        $todoItem->user_id = $this->user->id;
        $todoItem->title = $request->title;
        $todoItem->status = 'pending';
        $todoItem->position = $todos->count() == 0 ? 1 : $todos->count() + 1;

        $todoItem->save();

        if (request()->server('HTTP_REFERER') == route('admin.dashboard')) {
            $view = $this->generateTodoView();

            return Reply::successWithData(__('messages.todos.todoCreatedSuccessfully'), ['view' => $view]);
        }

        return Reply::success(__('messages.todos.todoCreatedSuccessfully'));
    }

    public function update(Request $request, $id)
    {
        $todoItem = $this->user->todoItems()->where('id', $id)->firstOrFail();

        if ($todoItem->status !== $request->status) {

            $todoItemsToUpdate = $this->todoItems->filter(function ($value, $key) use($todoItem) {
                return $value->status == $todoItem->status && $value->position > $todoItem->position;
            });

            $lastTodoItem = $this->todoItems->last(function ($value, $key) use($request) {
                return $value->status == $request->status;
            });

            $position = !is_null($lastTodoItem) ? $lastTodoItem->position + 1 : 1;

            if ($todoItemsToUpdate->count() > 0) {
                foreach ($todoItemsToUpdate as $todoItemToUpdate) {
                    $todoItemToUpdate->position = $todoItemToUpdate->position - 1;
                    $todoItemToUpdate->save();
                }
            }

            $todoItem->position = $position;
            $todoItem->status = $request->status;
        }

        $todoItem->title = $request->title;

        $todoItem->save();

        if (request()->server('HTTP_REFERER') == route('admin.dashboard')) {
            $view = $this->generateTodoView();

            return Reply::successWithData(__('messages.todos.todoUpdatedSuccessfully'), ['view' => $view]);
        }

        return Reply::success(__('messages.todos.todoUpdatedSuccessfully'));
    }

    public function destroy(Request $request, $id)
    {
        $todoItem = $this->user->todoItems()->where('id', $id)->firstOrFail();

        $allAfterTodos = $this->todoItems->filter(function ($value, $key) use($todoItem) {
            return $value->status == $todoItem->status && $value->position > $todoItem->position;
        });

        if ($allAfterTodos->count() > 0) {
            foreach ($allAfterTodos as $todo) {
                $todo->position = $todo->position - 1;
                $todo->save();
            }
        }

        $todoItem->delete();

        if (request()->server('HTTP_REFERER') == route('admin.dashboard')) {
            $view = $this->generateTodoView();

            return Reply::successWithData(__('messages.todos.todoDeletedSuccessfully'), ['view' => $view]);
        }

        return Reply::success(__('messages.todos.todoDeletedSuccessfully'));
    }

    public function updateTodoItem(Request $request)
    {
        $todoItem = $this->user->todoItems()->where('id', $request->id)->firstOrFail();
        
        if ($request->position) {
            $oldPosition = $request->position['oldPosition'];
            $newPosition = $request->position['newPosition'];
        }
        else {
            $oldPosition = $todoItem->position;
            $lastTodoItem = $this->todoItems->last(function($value, $key) use ($request) {
                return $value->status == $request->status;
            });

            $newPosition = !is_null($lastTodoItem) ? $lastTodoItem->position + 1 : 1;
        }

        if ($request->exists('status')) {
            if ($request->status == 'completed') {
                $pendingTodoItemsGreaterThanOldPosition = $this->todoItems->filter(function ($value, $key) use($todoItem, $oldPosition) {
                    return $value->status == $todoItem->status && $value->position > $oldPosition;
                });

                foreach ($pendingTodoItemsGreaterThanOldPosition as $pending) {
                    $pending->position = $oldPosition;
                    $pending->save();
                    $oldPosition++;
                }

                $completedTodoItemsGreaterThanOldPosition = $this->todoItems->filter(function ($value, $key) use($todoItem, $newPosition) {
                    return $value->status == 'completed' && $value->position >= $newPosition;
                });

                foreach ($completedTodoItemsGreaterThanOldPosition as $completed) {
                    $newPosition++;
                    $completed->position = $newPosition;
                    $completed->save();
                }
            }
            else {
                $pendingTodoItemsGreaterThanOldPosition = $this->todoItems->filter(function ($value, $key) use($todoItem, $newPosition) {
                    return $value->status == 'pending' && $value->position >= $newPosition;
                });

                foreach ($pendingTodoItemsGreaterThanOldPosition as $pending) {
                    $newPosition++;
                    $pending->position = $newPosition;
                    $pending->save();
                }

                $completedTodoItemsGreaterThanOldPosition = $this->todoItems->filter(function ($value, $key) use($todoItem, $oldPosition) {
                    return $value->status == $todoItem->status && $value->position > $oldPosition;
                });

                foreach ($completedTodoItemsGreaterThanOldPosition as $completed) {
                    $completed->position = $oldPosition;
                    $completed->save();
                    $oldPosition++;
                }
            }
            $todoItem->status = $request->status;
            $todoItem->position = $request->position ? $request->position['newPosition'] : $newPosition;
            $todoItem->save();
        }
        else {
            $status = $todoItem->status;
            $todos = $this->user->todoItems()->status($status)->orderBy('position')->get();
            $oldTodo = $todos->filter(function ($value, $key) use($oldPosition) {
                return $value->position == $oldPosition;
            })->first();

            $betweenTodos = $todos->filter(function ($value, $key) use($oldPosition, $newPosition) {
                if ($newPosition > $oldPosition) {
                    $todos = $value->position > $oldPosition && $value->position <= $newPosition;
                }
                else {
                    $todos = $value->position < $oldPosition && $value->position >= $newPosition;
                }

                return $todos;
            });

            if ($betweenTodos->count() > 0) {
                foreach ($betweenTodos as $todo) {
                    if ($newPosition > $oldPosition) {
                        $todo->position = $todo->position - 1;
                    }
                    else {
                        $todo->position = $todo->position + 1;
                    }
                    $todo->save();
                }
            }

            if ($oldTodo->count() > 0) {
                $oldTodo->position = $newPosition;

                $oldTodo->save();
            }
        }

        $view = $this->generateTodoView();

        return Reply::dataOnly(['view' => $view]);
    }
}
