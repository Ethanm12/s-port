<?php

namespace App\Http\Controllers;

use Cockpit\Cockpit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Base sitemap generator. Relys on having a 'route' field on the 'pages' collection in the cms.
 * 
 * More complicated urls (eg. /products/category/product), will simply have to include this route
 * field on the collection; pull in the collection, process it as below, and push it to 
 * the $output array.
 * 
 */
class SitemapController extends Controller
{
    public function index(Cockpit $cockpit)
    {
        $pages = $cockpit->get('pages');
        $output = array();
        $baseURL = 'https://boilerplate.test';

        foreach ($pages as $page) {
            if ($page['published']) {
                $item = ['loc' => $baseURL . $page['route'], 'changefreq' => 'monthly', 'priority' => '1'];
                array_push($output, $item);
            }
        }
        
        // Log::info($output);
        return response(
            view('sitemap')->with('output', $output)->render(), 200, [
                'Content-Type' => 'text/xml'
            ]
        );
    }
}
