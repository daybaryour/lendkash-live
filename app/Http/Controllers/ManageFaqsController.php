<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Repositories\Admin\CmsRepository;
use App\Http\Requests\AddFaqsValidation;

class ManageFaqsController extends Controller
{

    public function __construct(CmsRepository $cms)
    {
         $this->cmsRepository = $cms;
    }

    /**
     * load faq index page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getFaqs = $this->cmsRepository->getFaqsList();
        return view('manage-faq.index',['getFaqsList' => $getFaqs]);
    }

    /**
     * load faq index page
     * @return \Illuminate\Http\Response
     */
    public function addFaq()
    {
        return view('manage-faq.add-faq');
    }

    /**
     * load edit faq page
     * @return \Illuminate\Http\Response
     */
    public function editFaq($id)
    {
        $getFaqs = $this->cmsRepository->getFaqById(base64_decode($id));
        return view('manage-faq.edit-faq',['getFaqs' => $getFaqs]);
    }

    /**
     * save faq
     * @return \Illuminate\Http\Response
     */
    public function saveFaqs(AddFaqsValidation $request)
    {
      try {
            return  $this->cmsRepository->saveFaqs($request);
        } catch (Exception $ex) {
            return json_encode(array('success' => 'false', 'message' => $e->getMessage()));
        }
    }

    /**
     * update faq
     * @return \Illuminate\Http\Response
     */
    public function updateFaqs(AddFaqsValidation $request)
    {
      try {
            return  $this->cmsRepository->updateFaqs($request);
        } catch (Exception $ex) {
             return json_encode(array('success' => 'false', 'message' => $e->getMessage()));
        }
    }

}
