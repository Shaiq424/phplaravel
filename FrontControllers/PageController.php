<?php

namespace App\Http\Controllers\FrontControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HomeSlider;
use App\Models\Blog;
use App\Models\Testimonials;
use App\Models\DistrictMunciple;
use App\Models\ComplainBox;
use App\Models\Contact;
use App\Models\SocialMedia;
use App\Models\HeaderMenu;
use App\Models\PressRelease;
use App\Models\SubMenu;
use App\Models\QuickLinks;
use App\Models\Footer;
use App\Models\Events;
use App\Models\RecentEvent;
use App\Models\Headings;
use App\Models\Laws;
use App\Models\EnvironmentManagementFramework;
use App\Models\Functions;
use App\Models\FunctionsPoints;
use App\Models\SocialManagementFramework;
use App\Models\Zone;
use App\Models\ZoneDetail;
use App\Models\About;
use App\Models\ComplainForm;
use App\Models\StaffDirectorys;
use App\Models\UC;
use App\Models\NOC;
use App\Models\Enviroment;
use App\Models\BudgetBook;
use App\Models\Tender;
use App\Models\Law;
use App\Models\Click;
use App\Models\MeetingMinute;
use App\Models\TradeLicense;
use App\Models\ProcurementPlan;
use App\Models\Notification;
use App\Models\Advertisement;
use App\Models\Latest;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{

    public function homepage()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        // dd($data ['headermenu']);           
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        // dd($data ['submenu']);
        $data ['slider'] = HomeSlider::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['blog'] = Blog::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['testimonials'] = Testimonials::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['districtmunciple'] = DistrictMunciple::whereLangId(Session::get('lang_id'))->get();
        $data ['complainbox'] = ComplainBox::whereLangId(Session::get('lang_id'))->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['functions_sec'] = Functions::whereLangId(Session::get('lang_id'))->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        // ->orderBy('id','asc')->first();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
         $data ['latest'] = Latest::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();        

    return view('FrontPages.dmchome', $data);
    }

    public function news($slug)
    {
        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        // dd($data ['headermenu']);
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['news'] = Blog::whereLangId(Session::get('lang_id'))->where('status',1)
        ->where("blogs.slug",$slug)
        ->get();
        $data ['breadcrum'] = Blog::whereLangId(Session::get('lang_id'))->where('status',1)
        ->where("blogs.slug",$slug)
        ->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();
        
        return view('FrontPages.news', $data);
    }



    // departments
    public function departments()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.departments', $data);
    }
    // about
    public function about()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['about'] = About::whereLangId(Session::get('lang_id'))->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.about', $data);
    }
    // radmore-banner
    // public function radmore_banner()  {

    //     $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    //     $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    //     $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        
    //     $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    //     $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    //     $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    //     $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    //     $data ['socialmedia'] = SocialMedia::get();
    //     $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    // return view('FrontPages.radmore_banner', $data);
    // }
    
    //contact
    public function contact()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['contact'] = Contact::whereLangId(Session::get('lang_id'))->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.contact', $data);
    }
    //Functions
    public function functions()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['functions'] = Functions::whereLangId(Session::get('lang_id'))->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        // $data ['events'] = Events::orderBy('id', 'DESC')->where('status',1)->take(6)->get();

    return view('FrontPages.functions', $data);
    }
    
    //Laws
    public function Laws()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['laws'] = Laws::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.Laws', $data);
    }
    
    //EMF
    public function emframework()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['emframework'] = EnvironmentManagementFramework::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.emframework', $data);
    }
    
    //smframework
    public function smframework()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['smframework'] = SocialManagementFramework::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.smframework', $data);
    }
    
    //Organogram
    public function Organogram()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.Organogram', $data);
    }
    //Events
    public function Events()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.Events', $data);
    }
    //ucandzone
    public function ucandzone()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['uc'] = UC::distinct()->get('zone');
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.ucandzone', $data);
    }
    
    
    //esrs
    public function esrs()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['enviroment'] = Enviroment::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.esrs', $data);
    }
    
    
    
    //budgetbook
    public function budgetbook()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['budgetbook'] = BudgetBook::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.budgetbook', $data);
    }
    
    
    //staffdirectory
    public function staffdirectory()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['staffdirectory'] = StaffDirectorys::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.staffdirectory', $data);
    }
    
    
    //complain
    public function complain()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.complain', $data);
    }
    
    
    //click
    public function click()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.click', $data);
    }
    
    
    
    //eventphoto
    public function eventphoto()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::where('status',1)->paginate(9);
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.eventphoto', $data);
    }
    
    
    //eventdetail
    public function eventdetail($id)  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::where('id',$id)->where('status',1)->first();
        $data ['recentevent'] = RecentEvent::where('event_id',$id)->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.eventdetail', $data);
    }
    
    
    
    //minimum
    public function minimum()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['minimum'] = Click::where('category','Minimum Condition Grants')->get();
        $data ['performance'] = Click::where('category','Performance Based Grants')->get();
        $data ['covid'] = Click::where('category','Covid-19 Grants')->get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.minimum', $data);
    }
    
    
    
    //perfomance
    public function perfomance()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['minimum'] = Click::where('category','Minimum Condition Grants')->get();
        $data ['performance'] = Click::where('category','Performance Based Grants')->get();
        $data ['covid'] = Click::where('category','Covid-19 Grants')->get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.perfomance', $data);
    }
    
    
    
    //covid
    public function covid()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['minimum'] = Click::where('category','Minimum Condition Grants')->get();
        $data ['performance'] = Click::where('category','Performance Based Grants')->get();
        $data ['covid'] = Click::where('category','Covid-19 Grants')->get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.covid', $data);
    }
    
    //Tender
    public function tender()  {

        $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
        $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
        $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
        $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
        $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
        $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
        $data ['socialmedia'] = SocialMedia::get();
        $data ['tender'] = Tender::get();
        $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

        

    return view('FrontPages.tender', $data);
    }

  //procurmentplan
  public function procurmentplan()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data['noc'] = ProcurementPlan::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.procurmentplan', $data);
    }
   //noc
  public function noc()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['noc'] = NOC::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.noc', $data);
    }

    //notification
  public function notification()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['noc'] = Notification::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.notification', $data);
    }




    //advertisement
  public function advertisement()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['noc'] = Advertisement::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.advertisement', $data);
    }
    

//meetingmin
public function meetingmin()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['noc'] = MeetingMinute::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.meetingmin', $data);
    }
    

    //trade
    public function trade()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['noc'] = TradeLicense::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.trade', $data);
    }
    
    
    
    //pressrelease
    public function pressrelease()  {

    $data ['headermenu'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['headermenu_inner'] = HeaderMenu::with('getsub_menu')->whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['submenu'] = SubMenu::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['zone'] = Zone::whereLangId(Session::get('lang_id'))->get();
    $data ['zonedlyari'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 1])->get();
    $data ['zonesadar'] = ZoneDetail::whereLangId(Session::get('lang_id'))->where(['status' => 1, 'is_zone' => 2])->get();
    $data ['quicklinks'] = QuickLinks::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['events'] = Events::whereLangId(Session::get('lang_id'))->where('status',1)->get();
    $data ['recentevent'] = RecentEvent::join('events','event_gallery.event_id','=','events.id')->get();
    $data ['footer'] = Footer::whereLangId(Session::get('lang_id'))->get();
    $data ['socialmedia'] = SocialMedia::get();
    $data ['tender'] = Tender::get();
    $data ['press'] = PressRelease::get();
    $data ['headings'] = Headings::whereLangId(Session::get('lang_id'))->get();

    

    return view('FrontPages.pressrelease', $data);
    }
}
