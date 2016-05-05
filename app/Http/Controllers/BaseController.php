<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $user;
    protected $pagination_limit = 10;

    public function __construct()
    {
        if (Auth::check()) {
            $this->user = Auth::user();
        }
    }

    public function debug($data, $die = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($die)
            die();
    }
}
