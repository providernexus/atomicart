<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Language extends BaseController
{
    public function index()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        $url = previous_url();
        return redirect()->to($url);
    }
}
