<?php

namespace App\Repositories\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Models\Support;


class SupportRepository {

    public function __construct(User $user, Support $support) {
        $this->user = $user;
        $this->support = $support;

    }

    /**
     * Load support list
     * @param string
     * @return object
     */
    public function loadSupportList($request) {
        if (request()->ajax()) {
            $sql = $this->support->with('user')->where('id','<>',0);
            if (!empty($request->application_id)) {
                $sql->where('request_id',$request->application_id);
            }
            return $sql->latest('id')->get();
        }
    }

}
