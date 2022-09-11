<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home.php');
    }

    public function aboutus()
    {
        return view('about.php');
    }

    public function service()
    {
        return view('service.php');
    }

    public function blog()
    {
        return view('blog');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sales()
    {
        return view('sales');
    }

    public function salesAgent()
    {
        return view('sales_agent');
    }

    public function teamlead()
    {
        return view('team_leader_sales');
    }

    public function login()
    {
        return view('login');
    }
}
