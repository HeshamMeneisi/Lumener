<?php
namespace Lumener\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class LumenerController extends Controller
{
    protected $adminer;
    protected $request;
    public function __construct(Request $request)
    {
        if (method_exists(\Route::class, 'hasMiddlewareGroup')
        &&\Route::hasMiddlewareGroup('adminer')) {
            $this->middleware('adminer');
        }
        // LumenerServiceProvider::register holds the middleware register so it does not need addeed manually.
        // User-defined middleware is handled during route definition for Lumen
        $this->adminer = __DIR__.'/../resources/adminer.php';
        $this->request = $request;
    }

    public function index()
    {
        if (file_exists($this->adminer)) {
            require($this->adminer);
        } else {
            return view('adminer::not_found');
        }
    }
}