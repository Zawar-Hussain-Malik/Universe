<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about() { return view('about'); }

    public function departments() { return view('departments'); }

    public function contact() { return view('contact'); }

    public function helpdesk() { return view('helpdesk'); }

    public function announcements() { return view('announcements'); }
}
