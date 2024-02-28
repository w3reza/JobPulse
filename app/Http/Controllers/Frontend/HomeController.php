<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        //$latestJobs = Job::orderBy('id', 'desc')->limit(5)->get();
        $jobs = Job::orderBy('id', 'desc')->with('category', 'skills')->limit(5)->get();
        return view('frontend.pages.home.index', compact('jobs'));
    }
}
