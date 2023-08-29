<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\SupportRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class SupportController extends Controller
{

    public function __construct(SupportRepository $support)
    {
        $this->support = $support;
    }

    /**
     * Load customer
     * @param  object
     * @return object
     */
    public function index(Request $request)
    {
        try {
            if (request()->ajax()) {
                $data = $this->support->loadSupportList($request);
                $action_type_info['type'] = 'support';
                $action_type_info['columnType'] = 'description';
                return DataTables::of($data)->addColumn('description', function ($data) use ($action_type_info) {
                    return view('datatable-action', compact('action_type_info', 'data'));
                })
                ->editColumn('action', function ($data){
                    return '<a class="btn btn-primary ripple-effect text-uppercase" href="mailto:'.$data['user']['email'].'">Reply</a>';
                })
                    ->rawColumns(['action','description'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('support.index');
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }


}
