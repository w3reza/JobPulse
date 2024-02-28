<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class backendController extends Controller
{
   public function index()
   {
       return view('backend.pages.home');
   }

}
