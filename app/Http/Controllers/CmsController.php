<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\CmsRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CmsValidation;

class CmsController extends Controller
{

    public function __construct(CmsRepository $cmsRepository)
    {
        $this->cmsRepository = $cmsRepository;
    }

     /**
     * get CMS Data.
     * @return object
     */
    public function index()
    {
        try {
            $modal = $this->cmsRepository->getCmsPagesList();
            return view('manage-cms.index',['modal' => $modal]);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }

    /**
     * get CMS detail by id.
     * @param  int
     * @return object
     */
    public function editCms($id)
    {
        try{
            $id = base64_decode($id);
            $data = $this->cmsRepository->getCmsData($id);
            return view("manage-cms.edit-cms", compact('data'));
        } catch (\Exception $e) {
            \Session::flash('error_msg', $e->getMessage());
            return back();
        }
    }
    /**
     * Update Cms.
     * @param  object
     * @return object
     */
    public function updateCms(CmsValidation $request)
    {
        try {
            return $this->cmsRepository->updateCms($request);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }


     /**
     * get CMS for Application.
     * @return HTML
     */
    public function cmsWebView($type)
    {
        try {
            if($type=='faq'){
                $data['type'] = 'faq';
                $data['getFaqsList'] = $this->cmsRepository->getFaqsList();
            }else{
                $data['type'] = 'cms';
                $data['cmsData'] = $this->cmsRepository->getCmsDetail($type);
            }
            return view('cms-web-view',$data);
        } catch (\Exception $e) {
            return json_encode(['success' => 'no', 'message' => $e->getMessage()]);
        }
    }

}
