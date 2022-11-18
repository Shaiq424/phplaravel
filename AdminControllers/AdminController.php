<?php

namespace App\Http\Controllers\Admincontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Models\Testimonials;
use App\Models\Blog;
use App\Models\QuickLinks;

class AdminController extends Controller
{
    public function dashboard()  {

        $count_quicklinks = QuickLinks::count();
        $count_testimonials = Testimonials::count();
        $count_soicalmedia = SocialMedia::count();
        $count_blogs = Blog::count();
        return view('admin.dashboard', compact('count_quicklinks', 'count_testimonials', 'count_soicalmedia', 'count_blogs'));
    
    }
}