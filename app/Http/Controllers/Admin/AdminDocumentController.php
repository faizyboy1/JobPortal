<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Admin\Document\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class AdminDocumentController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.themeSettings');
        $this->pageIcon = 'ti-settings';
    }

    public function index()
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        return view('admin.documents.index', ['documentable_type' => request()->documentable_type, 'documentable_id' => request()->documentable_id]);
    }

    public function store(StoreRequest $request)
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);
        
        $record = $request->documentable_type::with(['documents'])->select('id')->where('id', $request->documentable_id)->first();

        $hashname = Files::upload($request->file, 'documents/'.$request->documentable_id, null, null, false);

        $record->documents()->create([
            'name' => $request->name,
            'hashname' => $hashname
        ]);

        return Reply::success(__('messages.documentAddedSuccessfully'));
    }

    public function destroy(Document $document)
    {
        abort_if(!$this->user->cans('delete_job_applications'), 403);

        Files::deleteFile($document->hashname, 'documents/'.$document->documentable_id);

        $document->delete();

        return Reply::success(__('messages.documentDeletedSuccessfully'));
    }

    public function data(Request $request)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $documents = $request->documentable_type::select('id')->with(['documents'])->where('id', $request->documentable_id)->first()->documents;

        return DataTables::of($documents)
            ->addColumn('action', function ($row) {
                $action = '';

                if ($this->user->cans('view_job_applications')) {
                    $action .= '<a href="' . route('admin.documents.downloadDoc', $row->id) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="' . __('app.download') . '"><i class="fa fa-download" aria-hidden="true"></i></a>';
                }

                if ($this->user->cans('delete_job_applications')) {
                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-document"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return $action;
            })
            ->editColumn('name', function ($row) {
                return ucwords($row->name);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function downloadDoc(Document $document)
    {
        abort_if(!$this->user->cans('view_job_applications'), 403);

        $filePath = public_path('user-uploads/documents/'.$document->documentable->id.'/'.$document->hashname);

        return response()->download($filePath, snake_case(strtolower($document->name)) . '.' . File::extension($filePath));
    }
}
