<?php

namespace App\Repositories;

use App\Models\PaymentTransaction;
use App\Models\SavedCard;
use DB;

class PaymentRepository
{

    public function __construct(PaymentTransaction $payment, SavedCard $saveCard)
    {
        $this->payment = $payment;
        $this->saveCard = $saveCard;
    }

    /**
     * create Payment
     *  @param  object
     * @return id
     */
    public function createPayment($data)
    {
        return $this->payment->create($data);
    }
    /**
     * save Payment
     *  @param  object
     * @return object
     */
    public function savePayment($data, $id)
    {
        return  $this->payment->where('id', $id)->update($data);
    }
    /**
     * delete save card
     *  @param  integer
     * @return boolean
     */
    public function deleteSaveCard($id)
    {
        return  SavedCard::where(['id' => $id])->delete();
    }
    /**
     * save card
     *  @param  object
     * @return id
     */
    public function saveCard($cardData)
    {
        $cards = $this->saveCard->where(['user_id'=>$cardData['user_id'],'embed_token'=>$cardData['embed_token']])->first('id');
        if(!$cards){
            return $this->saveCard->create($cardData);
        }
    }
    /**
     * get saved card
     * @param  object
     * @return id
     */
    public function getSavedCards($userId)
    {
        return $this->saveCard->where('user_id',$userId)->latest('id')->paginate(10);
    }

}
