<?php

namespace App\Http\Controllers;

use App\Utils\SSR;
use Cockpit\Cockpit;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var Cockpit */
    protected $cockpit;

    /** @var SSR */
   protected $ssr;

    public function __construct(Cockpit $cockpit, SSR $ssr)
    {
        $this->cockpit = $cockpit;
        $this->ssr = $ssr;
    }

    /**
     * Get all published resources.
     *
     * @param $collection
     * @return mixed
     */
    public function published($collection)
    {
        return collect($this->cockpit->get($collection))->where('published', true);
    }
}
