<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function webView(Request $request) 
    {
        $ssrContent = $this->ssr->getContent($request->path());
        return view('welcome', ['ssrContent' => $ssrContent]);
    }

    public function getCmsContent(Request $request) {
        $data = $this->cockpit->all();
        $data['pages'] = array_filter($data['pages'], function($page) {
            return $page['published'];
        });

        return $data;
    }
}