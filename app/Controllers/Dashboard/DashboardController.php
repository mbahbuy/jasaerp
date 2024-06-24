<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    // public function __construct()
    // {
    //     if(isset($_COOKIE['login'])) {
    //         $cookie_name = "idi";
    //         $cookie_value = $_COOKIE['login'];
    //         setcookie($cookie_name, $cookie_value, time() + (3600 * 1), "/"); // 3600 = 1 hour
    //     }
    //     else {
    //         $this->user = '';
    //     }
    // }

    public function index()
    {
        // if (empty($this->user)) {
        //     return redirect()->route('login');
        // }

        // echo "DASHBOARD VIEW STARTING HERE";
        return view('dashboard/index', [
            'title' => 'Dashboard',
            'hal' => 'dashboard/index'
        ]);
    }

    public function login()
    {
        echo view('dashboard/login');
    }

    public function template()
    {
        return view('dashboard/template', [
            'title' => 'Template',
            'hal' => 'template'
        ]);
    }
}
