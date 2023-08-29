<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\Setting;
use App\Models\Cms;
use App\Models\Faqs;
use DB;

class SettingRepository
{

    public function __construct(Support $support, Setting $setting, Cms $cms, Faqs $faqs)
    {
        $this->support = $support;
        $this->setting = $setting;
        $this->cms = $cms;
        $this->faqs = $faqs;
    }

    /**
     * Support Request
     *  @param  object
     * @return boolean
     */
    public function supportRequest($request)
    {
        return $this->support->create($request);
    }

}
