<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\Faqs;


class CmsRepository {

    public function __construct(Cms $cms, Faqs $faqs) {
        $this->cms = $cms;
        $this->faqs = $faqs;
    }

    /**
     * Get Cms data
     * @param object
     * @return type
     */
    public function getCmsPagesList() {
        return $this->cms->get();
    }

    /**
     * Get Cms data by id
     * @param int, string
     * @return object
     */
    public function getCmsData($id) {
        return $this->cms->where('id', $id)->first();
    }
    /**
     * Update Cms
     * @param object
     * @return object
     */
    public function updateCms($request) {
        try{

            $post = $request->all();
            $model = $this->cms->where('id', $post['pageId'])->first();
            if($model){
                $model->title = $post['title'];
                $model->content =  $post['content'];
                if($model->save()){
                    return json_encode(array('success' => true, 'message' => $request['title'].' data updated successfully!'));
                }else{
                    return json_encode(array('success' => false, 'message' => 'Please try again'));
                }
            }else{
                return json_encode(array('success' => false, 'message' => 'Please try again'));
            }
        } catch (\Exception $e) {
            return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

    /**
     * save faqs
     * @param type $request
     * @return type
     */
    public function saveFaqs($request){
        try {
            $post = $request->all();
            $model = new $this->faqs();
            $model->question = $post['question'];
            $model->answer =  $post['answer'];
            if($model->save()){
                return json_encode(array('success' => true, 'message' => 'Faq added successfully.'));
            }else{
                return json_encode(array('success' => false, 'message' => 'Please try again'));
            }
        } catch (Exception $ex) {
           return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }
    /**
     * update faqs
     * @param type $request
     * @return type
     */
    public function updateFaqs($request){
        try {
            $post = $request->all();
            $model = $this->faqs->where('id', $post['faqId'])->first();
            if($model){
                $model->question = $post['question'];
                $model->answer =  $post['answer'];
                if($model->save()){
                    return json_encode(array('success' => true, 'message' => 'Faq updated successfully.'));
                }else{
                    return json_encode(array('success' => false, 'message' => 'Please try again'));
                }
            }else{
                return json_encode(array('success' => false, 'message' => 'Please try again'));
            }
        } catch (Exception $ex) {
           return json_encode(array('success' => false, 'message' => $e->getMessage()));
        }
    }

  /**
   * get Faqs List
   * @return type
   */
    public function getFaqsList() {
        return $this->faqs->get();
    }

    /**
     * get faq by id
     * @return type object
     */
    public function getFaqById($id) {
        return $this->faqs->where('id',$id)->first();
    }


    /**
     * Get CMS Details
     * @param  string
     * @return array
     */
    public function getCmsDetail($type)
    {
        return  $this->cms->where('type', $type)->first();
    }
}
