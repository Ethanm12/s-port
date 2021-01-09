<?php

namespace App\Http\Controllers;

use App\Exceptions\PageNotFoundException;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Fetch the page with the given name.
     *
     * @param $pageName
     * @return mixed
     * @throws PageNotFoundException
     */
    public function getPage($pageName)
    {
        $pages = $this->published('pages');
        $page = $pages->where('route', $pageName)->first();

        if(is_null($page)) {
            throw new PageNotFoundException($pageName);
        }
        
        return $page;
    }

    public function getContact() {
        return $this->published('contact');
    }

    public function getHome() {
        return $this->published('home');
    }
}
