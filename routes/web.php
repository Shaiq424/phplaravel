<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\FrontControllers\PageController;
use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\HomeSliderController;
use App\Http\Controllers\AdminControllers\BlogController;
use App\Http\Controllers\AdminControllers\TestimonialsController;
use App\Http\Controllers\AdminControllers\MuncipleController;
use App\Http\Controllers\AdminControllers\social_media;
use App\Http\Controllers\AdminControllers\FooterController;
use App\Http\Controllers\AdminControllers\ComplainBoxController;
use App\Http\Controllers\AdminControllers\header_menu;
use App\Http\Controllers\AdminControllers\sub_menu;
use App\Http\Controllers\AdminControllers\QuickLinksController;
use App\Http\Controllers\AdminControllers\profile_controller;
use App\Http\Controllers\AdminControllers\contact_us;
use App\Http\Controllers\AdminControllers\AboutController;
use App\Http\Controllers\AdminControllers\laws_acts;
use App\Http\Controllers\AdminControllers\StaffDirectory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group( function () {

        // Front Header Menu crud
        Route::get('/headermenu', [App\Http\Controllers\AdminControllers\header_menu::class, 'index'])->name('headermenu_display');
        Route::get('/headermenu/add', [App\Http\Controllers\AdminControllers\header_menu::class, 'add'])->name('headermenu_add');
        Route::post('/headermenu/store', [App\Http\Controllers\AdminControllers\header_menu::class, 'store'])->name('headermenu_store');
        Route::get('/headermenu/edit/{id}', [App\Http\Controllers\AdminControllers\header_menu::class, 'edit'])->name('headermenu_edit');
        Route::post('/headermenu/update/{id}', [App\Http\Controllers\AdminControllers\header_menu::class, 'update'])->name('headermenu_update');
        Route::get('/headermenu/delete/{id}', [App\Http\Controllers\AdminControllers\header_menu::class, 'delete'])->name('headermenu_delete');
        Route::post('/headermenu_data', [App\Http\Controllers\AdminControllers\header_menu::class, 'ajaxdata'])->name('headermenu_datatable');
        // status onclick on off
        Route::post('/menu_status/{id}', [App\Http\Controllers\AdminControllers\header_menu::class, 'statusUpdate'])->name('headermenu.status.update');

        // Front Header Sub Menu crud
        Route::get('/submenu', [App\Http\Controllers\AdminControllers\sub_menu::class, 'index'])->name('submenu_display');
        Route::get('/submenu/add', [App\Http\Controllers\AdminControllers\sub_menu::class, 'add'])->name('submenu_add');
        Route::post('/submenu/store', [App\Http\Controllers\AdminControllers\sub_menu::class, 'store'])->name('submenu_store');
        Route::get('/submenu/edit/{id}', [App\Http\Controllers\AdminControllers\sub_menu::class, 'edit'])->name('submenu_edit');
        Route::post('/submenu/update/{id}', [App\Http\Controllers\AdminControllers\sub_menu::class, 'update'])->name('submenu_update');
        Route::get('/submenu/delete/{id}', [App\Http\Controllers\AdminControllers\sub_menu::class, 'delete'])->name('submenu_delete');
        Route::post('/submenu_data', [App\Http\Controllers\AdminControllers\sub_menu::class, 'ajaxdata'])->name('submenu_datatable');
        // status onclick on off
        Route::post('/submenu_status/{id}', [App\Http\Controllers\AdminControllers\sub_menu::class, 'statusUpdate'])->name('submenu.status.update');

        // Dashboard display 
        Route::get('/dashboard' ,[App\Http\Controllers\AdminControllers\AdminController::class, 'dashboard'])->name('dashboard');
        // Logout Dashboard
        Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout_dashboard');
         
        // Blog post Crud
        Route::get('/blog', [App\Http\Controllers\AdminControllers\BlogController::class, 'index'])->name('blog_display');
        Route::get('/blog/add', [App\Http\Controllers\AdminControllers\BlogController::class, 'add'])->name('blog_add');
        Route::post('/blog/store', [App\Http\Controllers\AdminControllers\BlogController::class, 'store'])->name('blog_store');
        Route::get('/blog/edit/{id}', [App\Http\Controllers\AdminControllers\BlogController::class, 'edit'])->name('blog_edit');
        Route::post('/blog/update/{id}', [App\Http\Controllers\AdminControllers\BlogController::class, 'update'])->name('blog_update');
        Route::get('/blog/delete/{id}', [App\Http\Controllers\AdminControllers\BlogController::class, 'delete'])->name('blog_delete');
        Route::post('/blog_data', [App\Http\Controllers\AdminControllers\BlogController::class, 'ajaxdata'])->name('blog_datatable');
        // status onclick on off
        Route::post('/blog_status/{id}', [App\Http\Controllers\AdminControllers\BlogController::class, 'statusUpdate'])->name('blog.status.update');

        // Testimonials Message Crud
        Route::get('/testimonials', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'index'])->name('testimonials_display');
        Route::get('/testimonials/add', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'add'])->name('testimonials_add');
        Route::post('/testimonials/store', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'store'])->name('testimonials_store');
        Route::get('/testimonials/edit/{id}', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'edit'])->name('testimonials_edit');
        Route::post('/testimonials/update/{id}', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'update'])->name('testimonials_update');
        Route::get('/testimonials/delete/{id}', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'delete'])->name('testimonials_delete');
        Route::post('/testimonials_data', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'ajaxdata'])->name('testimonials_datatable');
        // status onclick on off
        Route::post('/testimonials_status/{id}', [App\Http\Controllers\AdminControllers\TestimonialsController::class, 'statusUpdate'])->name('testimonials.status.update');

        // District Munciple Video Crud
        Route::get('/districtmunciple', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'index'])->name('district_munciple_display');
        Route::get('/districtmunciple/add', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'add'])->name('district_munciple_add');
        Route::post('/districtmunciple/store', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'store'])->name('district_munciple_store');
        Route::get('/districtmunciple/edit/{id}', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'edit'])->name('district_munciple_edit');
        Route::post('/districtmunciple/update/{id}', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'update'])->name('district_munciple_update');
        Route::get('/districtmunciple/delete/{id}', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'delete'])->name('district_munciple_delete');
        Route::post('/districtmunciple_data', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'ajaxdata'])->name('district_munciple_datatable');
        // status onclick on off
        Route::post('/districtmunciple_status/{id}', [App\Http\Controllers\AdminControllers\MuncipleController::class, 'statusUpdate'])->name('district_munciple.status.update');
    
        // Social media crud
        // Route::get('/socialmedia', [App\Http\Controllers\AdminControllers\social_media::class, 'index'])->name('socialmedia_display');
        Route::get('/socialmedia/add', [App\Http\Controllers\AdminControllers\social_media::class, 'add'])->name('socialmedia_add');
        Route::post('/socialmedia/store', [App\Http\Controllers\AdminControllers\social_media::class, 'store'])->name('socialmedia_store');
        Route::get('/socialmedia/edit', [App\Http\Controllers\AdminControllers\social_media::class, 'edit'])->name('socialmedia_edit');
        Route::post('/socialmedia/update/{id}', [App\Http\Controllers\AdminControllers\social_media::class, 'update'])->name('socialmedia_update');
        Route::get('/socialmedia/delete/{id}', [App\Http\Controllers\AdminControllers\social_media::class, 'delete'])->name('socialmedia_delete');
        Route::post('/socialmedia_data', [App\Http\Controllers\AdminControllers\social_media::class, 'ajaxdata'])->name('socialmedia_datatable');

        // District Munciple Video Crud
        Route::get('/footer', [App\Http\Controllers\AdminControllers\FooterController::class, 'index'])->name('footer_display');
        Route::get('/footer/add', [App\Http\Controllers\AdminControllers\FooterController::class, 'add'])->name('footer_add');
        Route::post('/footer/store', [App\Http\Controllers\AdminControllers\FooterController::class, 'store'])->name('footer_store');
        Route::get('/footer/edit/{id}', [App\Http\Controllers\AdminControllers\FooterController::class, 'edit'])->name('footer_edit');
        Route::post('/footer/update/{id}', [App\Http\Controllers\AdminControllers\FooterController::class, 'update'])->name('footer_update');
        Route::get('/footer/delete/{id}', [App\Http\Controllers\AdminControllers\FooterController::class, 'delete'])->name('footer_delete');
        Route::post('/footer_data', [App\Http\Controllers\AdminControllers\FooterController::class, 'ajaxdata'])->name('footer_datatable');

        // Complain Box Crud
        Route::get('/complainbox', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'index'])->name('complainbox_display');
        Route::get('/complainbox/add', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'add'])->name('complainbox_add');
        Route::post('/complainbox/store', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'store'])->name('complainbox_store');
        Route::get('/complainbox/edit/{id}', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'edit'])->name('complainbox_edit');
        Route::post('/complainbox/update/{id}', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'update'])->name('complainbox_update');
        Route::get('/complainbox/delete/{id}', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'delete'])->name('complainbox_delete');
        Route::post('/complainbox_data', [App\Http\Controllers\AdminControllers\ComplainBoxController::class, 'ajaxdata'])->name('complainbox_datatable');

        // Quick Links Crud
        Route::get('/quicklinks', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'index'])->name('quicklinks_display');
        Route::get('/quicklinks/add', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'add'])->name('quicklinks_add');
        Route::post('/quicklinks/store', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'store'])->name('quicklinks_store');
        Route::get('/quicklinks/edit/{id}', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'edit'])->name('quicklinks_edit');
        Route::post('/quicklinks/update/{id}', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'update'])->name('quicklinks_update');
        Route::get('/quicklinks/delete/{id}', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'delete'])->name('quicklinks_delete');
        Route::post('/quicklinks_data', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'ajaxdata'])->name('quicklinks_datatable');
        // status onclick on off
        Route::post('/quicklinks_status/{id}', [App\Http\Controllers\AdminControllers\QuickLinksController::class, 'statusUpdate'])->name('quicklinks_munciple.status.update');
        
        Route::get('/latest', [App\Http\Controllers\AdminControllers\LatestController::class, 'index'])->name('latest_display');
        Route::get('/latest/add', [App\Http\Controllers\AdminControllers\LatestController::class, 'add'])->name('latest_add');
        Route::post('/latest/store', [App\Http\Controllers\AdminControllers\LatestController::class, 'store'])->name('latest_store');
        Route::get('/latest/delete/{id}', [App\Http\Controllers\AdminControllers\LatestController::class, 'delete'])->name('latest_delete');
        Route::get('/latest/edit/{id}', [App\Http\Controllers\AdminControllers\LatestController::class, 'edit'])->name('latest_edit');
        Route::post('/latest/update/{id}', [App\Http\Controllers\AdminControllers\LatestController::class, 'update'])->name('latest_update');
        Route::post('/latest_data', [App\Http\Controllers\AdminControllers\LatestController::class, 'ajaxdata'])->name('latest_datatable');

        // recent event crud
        // Route::get('/recentevent', [App\Http\Controllers\AdminControllers\recent_events::class, 'index'])->name('recentevent_display');
        // Route::get('/recentevent/add', [App\Http\Controllers\AdminControllers\recent_events::class, 'add'])->name('recentevent_add');
        // Route::post('/recentevent/store', [App\Http\Controllers\AdminControllers\recent_events::class, 'store'])->name('recentevent_store');
        // Route::get('/recentevent/edit/{id}', [App\Http\Controllers\AdminControllers\recent_events::class, 'edit'])->name('recentevent_edit');
        // Route::post('/recentevent/update/{id}', [App\Http\Controllers\AdminControllers\recent_events::class, 'update'])->name('recentevent_update');
        // Route::get('/recentevent/delete/{id}', [App\Http\Controllers\AdminControllers\recent_events::class, 'delete'])->name('recentevent_delete');
        Route::post('/recentevent_data', [App\Http\Controllers\AdminControllers\recent_events::class, 'ajaxdata'])->name('recentevent_datatable');

        // event crud
        Route::get('/events', [App\Http\Controllers\AdminControllers\events_main::class, 'index'])->name('events_display');
        Route::get('/events/add', [App\Http\Controllers\AdminControllers\events_main::class, 'add'])->name('events_add');
        Route::post('/events/store', [App\Http\Controllers\AdminControllers\events_main::class, 'store'])->name('events_store');
        Route::get('/events/edit/{id}', [App\Http\Controllers\AdminControllers\events_main::class, 'edit'])->name('events_edit');
        Route::post('/events/update/{id}', [App\Http\Controllers\AdminControllers\events_main::class, 'update'])->name('events_update');
        Route::get('/events/delete/{id}', [App\Http\Controllers\AdminControllers\events_main::class, 'delete'])->name('events_delete');
        Route::post('/events_data', [App\Http\Controllers\AdminControllers\events_main::class, 'ajaxdata'])->name('events_datatable');
        Route::get('events_image/delete/{id}', [App\Http\Controllers\AdminControllers\events_main::class, 'imagedelete'])->name('events_img_delete');
        // status onclick on off
        Route::post('/events_status/{id}', [App\Http\Controllers\AdminControllers\events_main::class, 'statusUpdate'])->name('events.status.update');
       
        //  headings curd 
        Route::post('/headings/update/{id}', [App\Http\Controllers\AdminControllers\headings_controller::class, 'update'])->name('headings_update');
    
        // chnage Profile and password
        Route::get('password/edit/{id}', [App\Http\Controllers\AdminControllers\profile_controller::class, 'updateform'])->name('userupdate');
        Route::post('/update/{id}', [App\Http\Controllers\AdminControllers\profile_controller::class, 'update'])->name('user.update');
        Route::post('/updatename/{id}', [App\Http\Controllers\AdminControllers\profile_controller::class, 'nameupdate'])->name('username.update');
        Route::get('profile/edit/{id}', [App\Http\Controllers\AdminControllers\profile_controller::class, 'userupdateform'])->name('useruserupdate');

        // Dmc South Inner pages Crud Start 

        // Laws Acts Ordians crud
        Route::get('/laws', [laws_acts::class, 'index'])->name('laws_display');
        Route::get('/laws/add', [laws_acts::class, 'add'])->name('laws_add');
        Route::post('/laws/store', [laws_acts::class, 'store'])->name('laws_store');
        Route::get('/laws/edit/{id}', [laws_acts::class, 'edit'])->name('laws_edit');
        Route::post('/laws/update/{id}', [laws_acts::class, 'update'])->name('laws_update');
        Route::get('/laws/delete/{id}', [laws_acts::class, 'delete'])->name('laws_delete');
        Route::post('/laws_data', [laws_acts::class, 'ajaxdata'])->name('laws_datatable');
        // status onclick on off
        Route::post('/laws_status/{id}', [laws_acts::class, 'statusUpdate'])->name('laws.status.update');

        // Environment Management Framework crud
        Route::get('/emframework', [App\Http\Controllers\AdminControllers\emframework::class, 'index'])->name('emframework_display');
        Route::get('/emframework/add', [App\Http\Controllers\AdminControllers\emframework::class, 'add'])->name('emframework_add');
        Route::post('/emframework/store', [App\Http\Controllers\AdminControllers\emframework::class, 'store'])->name('emframework_store');
        Route::get('/emframework/edit/{id}', [App\Http\Controllers\AdminControllers\emframework::class, 'edit'])->name('emframework_edit');
        Route::post('/emframework/update/{id}', [App\Http\Controllers\AdminControllers\emframework::class, 'update'])->name('emframework_update');
        Route::get('/emframework/delete/{id}', [App\Http\Controllers\AdminControllers\emframework::class, 'delete'])->name('emframework_delete');
        Route::post('/emframework_data', [App\Http\Controllers\AdminControllers\emframework::class, 'ajaxdata'])->name('emframework_datatable');
        // status onclick on off
        Route::post('/emframework_status/{id}', [App\Http\Controllers\AdminControllers\emframework::class, 'statusUpdate'])->name('emframework.status.update');

        // Social Management Framework crud
        Route::get('/smframework', [App\Http\Controllers\AdminControllers\smframework::class, 'index'])->name('smframework_display');
        Route::get('/smframework/add', [App\Http\Controllers\AdminControllers\smframework::class, 'add'])->name('smframework_add');
        Route::post('/smframework/store', [App\Http\Controllers\AdminControllers\smframework::class, 'store'])->name('smframework_store');
        Route::get('/smframework/edit/{id}', [App\Http\Controllers\AdminControllers\smframework::class, 'edit'])->name('smframework_edit');
        Route::post('/smframework/update/{id}', [App\Http\Controllers\AdminControllers\smframework::class, 'update'])->name('smframework_update');
        Route::get('/smframework/delete/{id}', [App\Http\Controllers\AdminControllers\smframework::class, 'delete'])->name('smframework_delete');
        Route::post('/smframework_data', [App\Http\Controllers\AdminControllers\smframework::class, 'ajaxdata'])->name('smframework_datatable');
        // status onclick on off
        Route::post('/smframework_status/{id}', [App\Http\Controllers\AdminControllers\smframework::class, 'statusUpdate'])->name('smframework.status.update');

        // Contact us crud
        Route::get('/contact', [contact_us::class, 'index'])->name('contact_display');
        Route::get('/contact/add', [contact_us::class, 'add'])->name('contact_add');
        Route::post('/contact/store', [contact_us::class, 'store'])->name('contact_store');
        Route::get('/contact/edit/{id}', [contact_us::class, 'edit'])->name('contact_edit');
        Route::post('/contact/update/{id}', [contact_us::class, 'update'])->name('contact_update');
        Route::get('/contact/delete/{id}', [contact_us::class, 'delete'])->name('contact_delete');
        Route::post('/contact_data', [contact_us::class, 'ajaxdata'])->name('contact_datatable');

        // Functions crud
        Route::get('/functions', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'index'])->name('functions_display');
        Route::get('/functions/add', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'add'])->name('functions_add');
        Route::post('/functions/store', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'store'])->name('functions_store');
        Route::get('/functions/edit/{id}', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'edit'])->name('functions_edit');
        Route::post('/functions/update/{id}', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'update'])->name('functions_update');
        Route::post('/functions_data', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'ajaxdata'])->name('functions_datatable');
        // status onclick on off
        Route::post('/functions_status/{id}', [App\Http\Controllers\AdminControllers\FunctionsController::class, 'statusUpdate'])->name('functions.status.update');

        // zones Crud
        Route::get('/zone', [App\Http\Controllers\AdminControllers\ZoneController::class, 'index'])->name('zone_display');
        Route::get('/zone/edit/{id}', [App\Http\Controllers\AdminControllers\ZoneController::class, 'edit'])->name('zone_edit');
        Route::post('/zone/update/{id}', [App\Http\Controllers\AdminControllers\ZoneController::class, 'update'])->name('zone_update');
        Route::post('/zone_data', [App\Http\Controllers\AdminControllers\ZoneController::class, 'ajaxdata'])->name('zone_datatable');
        // Zone Details rud
        Route::get('/zonedetail', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'index'])->name('zonedetail_display');
        Route::get('/zonedetail/add', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'add'])->name('zonedetail_add');
        Route::post('/zonedetail/store', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'store'])->name('zonedetail_store');
        Route::get('/zonedetail/edit/{id}', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'edit'])->name('zonedetail_edit');
        Route::post('/zonedetail/update/{id}', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'update'])->name('zonedetail_update');
        Route::get('/zonedetail/delete/{id}', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'delete'])->name('zonedetail_delete');
        Route::post('/zonedetail_data', [App\Http\Controllers\AdminControllers\ZoneDetailController::class, 'ajaxdata'])->name('zonedetail_datatable');
        // status onclick on off
        Route::post('/zonedetail_status/{id}', [App\Http\Controllers\Admincontrollers\ZoneDetailController::class, 'statusUpdate'])->name('zonedetail.status.update');

        // About Crud
        Route::get('/about', [AboutController::class, 'index'])->name('about_display');
        Route::get('/about/edit/{id}', [AboutController::class, 'edit'])->name('about_edit');
        Route::post('/about/update/{id}', [AboutController::class, 'update'])->name('about_update');
        Route::post('/about_data', [AboutController::class, 'ajaxdata'])->name('about_datatable');

        //Staff Directory

        Route::get('/staff', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'index'])->name('staff_display');
        Route::get('/staff/add', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'add'])->name('staff_add');
        Route::post('/staff/store', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'store'])->name('staff_store');
        Route::get('/staff/edit/{id}', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'edit'])->name('staff_edit');
        Route::post('/staff/update/{id}', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'update'])->name('staff_update');
        Route::get('/staff/delete/{id}', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'delete'])->name('staff_delete');
        Route::post('/staff_data', [App\Http\Controllers\AdminControllers\StaffDirectory::class, 'ajaxdata'])->name('staff_datatable');

        Route::get('/uc', [App\Http\Controllers\AdminControllers\UCController::class, 'index'])->name('uc_display');
        Route::get('/uc/add', [App\Http\Controllers\AdminControllers\UCController::class, 'add'])->name('uc_add');
        Route::post('/uc/store', [App\Http\Controllers\AdminControllers\UCController::class, 'store'])->name('uc_store');
        Route::get('/uc/edit/{id}', [App\Http\Controllers\AdminControllers\UCController::class, 'edit'])->name('uc_edit');
        Route::post('/uc/update/{id}', [App\Http\Controllers\AdminControllers\UCController::class, 'update'])->name('uc_update');
        Route::get('/uc/delete/{id}', [App\Http\Controllers\AdminControllers\UCController::class, 'delete'])->name('uc_delete');
        Route::post('/uc_data', [App\Http\Controllers\AdminControllers\UCController::class, 'ajaxdata'])->name('uc_datatable');
        

        Route::get('/budgetbook', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'index'])->name('budgetbook_display');
        Route::get('/budgetbook/add', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'add'])->name('budgetbook_add');
        Route::post('/budgetbook/store', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'store'])->name('budgetbook_store');
        Route::get('/budgetbook/edit/{id}', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'edit'])->name('budgetbook_edit');
        Route::post('/budgetbook/update/{id}', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'update'])->name('budgetbook_update');
        Route::get('/budgetbook/delete/{id}', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'delete'])->name('budgetbook_delete');
        Route::post('/budgetbook_data', [App\Http\Controllers\AdminControllers\BudgetBooks::class, 'ajaxdata'])->name('budgetbook_datatable');

        Route::get('/enviroment', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'index'])->name('enviroment_display');
        Route::get('/enviroment/add', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'add'])->name('enviroment_add');
        Route::post('/enviroment/store', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'store'])->name('enviroment_store');
        Route::get('/enviroment/edit/{id}', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'edit'])->name('enviroment_edit');
        Route::post('/enviroment/update/{id}', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'update'])->name('enviroment_update');
        Route::get('/enviroment/delete/{id}', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'delete'])->name('enviroment_delete');
        Route::post('/enviroment_data', [App\Http\Controllers\AdminControllers\EnviromentController::class, 'ajaxdata'])->name('enviroment_datatable');

        Route::get('/tender', [App\Http\Controllers\AdminControllers\TenderController::class, 'index'])->name('tender_display');
        Route::get('/tender/add', [App\Http\Controllers\AdminControllers\TenderController::class, 'add'])->name('tender_add');
        Route::post('/tender/store', [App\Http\Controllers\AdminControllers\TenderController::class, 'store'])->name('tender_store');
        Route::get('/tender/edit/{id}', [App\Http\Controllers\AdminControllers\TenderController::class, 'edit'])->name('tender_edit');
        Route::post('/tender/update/{id}', [App\Http\Controllers\AdminControllers\TenderController::class, 'update'])->name('tender_update');
        Route::get('/tender/delete/{id}', [App\Http\Controllers\AdminControllers\TenderController::class, 'delete'])->name('tender_delete');
        Route::post('/tender_data', [App\Http\Controllers\AdminControllers\TenderController::class, 'ajaxdata'])->name('tender_datatable');

        Route::get('/click', [App\Http\Controllers\AdminControllers\ClickController::class, 'index'])->name('click_display');
        Route::get('/click/add', [App\Http\Controllers\AdminControllers\ClickController::class, 'add'])->name('click_add');
        Route::post('/click/store', [App\Http\Controllers\AdminControllers\ClickController::class, 'store'])->name('click_store');
        Route::get('/click/edit/{id}', [App\Http\Controllers\AdminControllers\ClickController::class, 'edit'])->name('click_edit');
        Route::post('/click/update/{id}', [App\Http\Controllers\AdminControllers\ClickController::class, 'update'])->name('click_update');
        Route::get('/click/delete/{id}', [App\Http\Controllers\AdminControllers\ClickController::class, 'delete'])->name('click_delete');
        Route::post('/click_data', [App\Http\Controllers\AdminControllers\ClickController::class, 'ajaxdata'])->name('click_datatable');

        Route::get('/complain', [App\Http\Controllers\AdminControllers\ComplainController::class, 'index'])->name('complain_display');
        Route::get('/complain/delete/{id}', [App\Http\Controllers\AdminControllers\ComplainController::class, 'delete'])->name('complain_delete');
        Route::post('/complain_data', [App\Http\Controllers\AdminControllers\ComplainController::class, 'ajaxdata'])->name('complain_datatable');

        Route::get('/notification', [App\Http\Controllers\AdminControllers\NotificationController::class, 'index'])->name('notification_display');
        Route::get('/notification/add', [App\Http\Controllers\AdminControllers\NotificationController::class, 'add'])->name('notification_add');
        Route::post('/notification/store', [App\Http\Controllers\AdminControllers\NotificationController::class, 'store'])->name('notification_store');
        Route::get('/notification/edit/{id}', [App\Http\Controllers\AdminControllers\NotificationController::class, 'edit'])->name('notification_edit');
        Route::post('/notification/update/{id}', [App\Http\Controllers\AdminControllers\NotificationController::class, 'update'])->name('notification_update');
        Route::get('/notification/delete/{id}', [App\Http\Controllers\AdminControllers\NotificationController::class, 'delete'])->name('notification_delete');
        Route::post('/notification_data', [App\Http\Controllers\AdminControllers\NotificationController::class, 'ajaxdata'])->name('notification_datatable');

        Route::get('/noc', [App\Http\Controllers\AdminControllers\NOCController::class, 'index'])->name('noc_display');
        Route::get('/noc/add', [App\Http\Controllers\AdminControllers\NOCController::class, 'add'])->name('noc_add');
        Route::post('/noc/store', [App\Http\Controllers\AdminControllers\NOCController::class, 'store'])->name('noc_store');
        Route::get('/noc/edit/{id}', [App\Http\Controllers\AdminControllers\NOCController::class, 'edit'])->name('noc_edit');
        Route::post('/noc/update/{id}', [App\Http\Controllers\AdminControllers\NOCController::class, 'update'])->name('noc_update');
        Route::get('/noc/delete/{id}', [App\Http\Controllers\AdminControllers\NOCController::class, 'delete'])->name('noc_delete');
        Route::post('/noc_data', [App\Http\Controllers\AdminControllers\NOCController::class, 'ajaxdata'])->name('noc_datatable');

        Route::get('/meeting', [App\Http\Controllers\AdminControllers\MeetingController::class, 'index'])->name('meeting_display');
        Route::get('/meeting/add', [App\Http\Controllers\AdminControllers\MeetingController::class, 'add'])->name('meeting_add');
        Route::post('/meeting/store', [App\Http\Controllers\AdminControllers\MeetingController::class, 'store'])->name('meeting_store');
        Route::get('/meeting/edit/{id}', [App\Http\Controllers\AdminControllers\MeetingController::class, 'edit'])->name('meeting_edit');
        Route::post('/meeting/update/{id}', [App\Http\Controllers\AdminControllers\MeetingController::class, 'update'])->name('meeting_update');
        Route::get('/meeting/delete/{id}', [App\Http\Controllers\AdminControllers\MeetingController::class, 'delete'])->name('meeting_delete');
        Route::post('/meeting_data', [App\Http\Controllers\AdminControllers\MeetingController::class, 'ajaxdata'])->name('meeting_datatable');

        Route::get('/procurement', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'index'])->name('procurement_display');
        Route::get('/procurement/add', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'add'])->name('procurement_add');
        Route::post('/procurement/store', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'store'])->name('procurement_store');
        Route::get('/procurement/edit/{id}', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'edit'])->name('procurement_edit');
        Route::post('/procurement/update/{id}', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'update'])->name('procurement_update');
        Route::get('/procurement/delete/{id}', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'delete'])->name('procurement_delete');
        Route::post('/procurement_data', [App\Http\Controllers\AdminControllers\ProcurementController::class, 'ajaxdata'])->name('procurement_datatable');

        Route::get('/tradelicense', [App\Http\Controllers\AdminControllers\TradeController::class, 'index'])->name('tradelicense_display');
        Route::get('/tradelicense/add', [App\Http\Controllers\AdminControllers\TradeController::class, 'add'])->name('tradelicense_add');
        Route::post('/tradelicense/store', [App\Http\Controllers\AdminControllers\TradeController::class, 'store'])->name('tradelicense_store');
        Route::get('/tradelicense/edit/{id}', [App\Http\Controllers\AdminControllers\TradeController::class, 'edit'])->name('tradelicense_edit');
        Route::post('/tradelicense/update/{id}', [App\Http\Controllers\AdminControllers\TradeController::class, 'update'])->name('tradelicense_update');
        Route::get('/tradelicense/delete/{id}', [App\Http\Controllers\AdminControllers\TradeController::class, 'delete'])->name('tradelicense_delete');
        Route::post('/tradelicense_data', [App\Http\Controllers\AdminControllers\TradeController::class, 'ajaxdata'])->name('tradelicense_datatable');

        Route::get('/advertisement', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'index'])->name('advertisement_display');
        Route::get('/advertisement/add', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'add'])->name('advertisement_add');
        Route::post('/advertisement/store', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'store'])->name('advertisement_store');
        Route::get('/advertisement/edit/{id}', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'edit'])->name('advertisement_edit');
        Route::post('/advertisement/update/{id}', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'update'])->name('advertisement_update');
        Route::get('/advertisement/delete/{id}', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'delete'])->name('advertisement_delete');
        Route::post('/advertisement_data', [App\Http\Controllers\AdminControllers\AdvertisementController::class, 'ajaxdata'])->name('advertisement_datatable');

        Route::get('/press', [App\Http\Controllers\AdminControllers\PressController::class, 'index'])->name('press_display');
        Route::get('/press/add', [App\Http\Controllers\AdminControllers\PressController::class, 'add'])->name('press_add');
        Route::post('/press/store', [App\Http\Controllers\AdminControllers\PressController::class, 'store'])->name('press_store');
        Route::get('/press/edit/{id}', [App\Http\Controllers\AdminControllers\PressController::class, 'edit'])->name('press_edit');
        Route::post('/press/update/{id}', [App\Http\Controllers\AdminControllers\PressController::class, 'update'])->name('press_update');
        Route::get('/press/delete/{id}', [App\Http\Controllers\AdminControllers\PressController::class, 'delete'])->name('press_delete');
        Route::post('/press_data', [App\Http\Controllers\AdminControllers\PressController::class, 'ajaxdata'])->name('press_datatable');
    });
});
Route::post('/complain/store', [App\Http\Controllers\AdminControllers\ComplainController::class, 'store'])->name('complain_store');


// Inner pages Routes

// departments
Route::get('/departments' ,[App\Http\Controllers\FrontControllers\PageController::class, 'departments'])->name('departments');


// about
Route::get('/about' ,[App\Http\Controllers\FrontControllers\PageController::class, 'about'])->name('about');

// radmore-banner
// Route::get('/radmore_banner' ,[App\Http\Controllers\FrontControllers\PageController::class, 'radmore_banner'])->name('radmore_banner');

// radmore-news1
Route::get('/news/{slug}' ,[App\Http\Controllers\FrontControllers\PageController::class, 'news'])->name('news');


// Contact
Route::get('/contact' ,[App\Http\Controllers\FrontControllers\PageController::class, 'contact'])->name('contact');

// functions
Route::get('/functions' ,[App\Http\Controllers\FrontControllers\PageController::class, 'functions'])->name('functions');

// Laws
Route::get('/laws' ,[App\Http\Controllers\FrontControllers\PageController::class, 'laws'])->name('laws');

// EMF
Route::get('/emframework' ,[App\Http\Controllers\FrontControllers\PageController::class, 'emframework'])->name('emframework');

// SMF
Route::get('/smframework' ,[App\Http\Controllers\FrontControllers\PageController::class, 'smframework'])->name('smframework');

// Organogram
Route::get('/Organogram' ,[App\Http\Controllers\FrontControllers\PageController::class, 'Organogram'])->name('Organogram');

// Events
Route::get('/Events' ,[App\Http\Controllers\FrontControllers\PageController::class, 'Events'])->name('Events');

// ucandzone
Route::get('/ucandzone' ,[App\Http\Controllers\FrontControllers\PageController::class, 'ucandzone'])->name('ucandzone');


// esrs
Route::get('/esrs' ,[App\Http\Controllers\FrontControllers\PageController::class, 'esrs'])->name('esrs');

// budgetbook
Route::get('/budgetbook' ,[App\Http\Controllers\FrontControllers\PageController::class, 'budgetbook'])->name('budgetbook');

// Inner pages Routes



// staffdirectory
Route::get('/staffdirectory' ,[App\Http\Controllers\FrontControllers\PageController::class, 'staffdirectory'])->name('staffdirectory');

// Inner pages Routes

// complain
Route::get('/complain' ,[App\Http\Controllers\FrontControllers\PageController::class, 'complain'])->name('complain');


// click
Route::get('/click' ,[App\Http\Controllers\FrontControllers\PageController::class, 'click'])->name('click');


// eventphoto
Route::get('/eventphoto' ,[App\Http\Controllers\FrontControllers\PageController::class, 'eventphoto'])->name('eventphoto');

// eventdetail
Route::get('/eventdetail/{id}' ,[App\Http\Controllers\FrontControllers\PageController::class, 'eventdetail'])->name('eventdetail');

// minimum
Route::get('/minimum' ,[App\Http\Controllers\FrontControllers\PageController::class, 'minimum'])->name('minimum');

// perfomance
Route::get('/perfomance' ,[App\Http\Controllers\FrontControllers\PageController::class, 'perfomance'])->name('perfomance');


// covid
Route::get('/covid' ,[App\Http\Controllers\FrontControllers\PageController::class, 'covid'])->name('covid');

// tender
Route::get('/tender' ,[App\Http\Controllers\FrontControllers\PageController::class, 'tender'])->name('tender');

// procurmentplan
Route::get('/procurmentplan' ,[App\Http\Controllers\FrontControllers\PageController::class, 'procurmentplan'])->name('procurmentplan');



// noc
Route::get('/noc' ,[App\Http\Controllers\FrontControllers\PageController::class, 'noc'])->name('noc');


// notification
Route::get('/notification' ,[App\Http\Controllers\FrontControllers\PageController::class, 'notification'])->name('notification');




// advertisement
Route::get('/advertisement' ,[App\Http\Controllers\FrontControllers\PageController::class, 'advertisement'])->name('advertisement');





// meetingmin
Route::get('/meetingmin' ,[App\Http\Controllers\FrontControllers\PageController::class, 'meetingmin'])->name('meetingmin');


// trade
Route::get('/trade' ,[App\Http\Controllers\FrontControllers\PageController::class, 'trade'])->name('trade');





// pressrelease
Route::get('/pressrelease' ,[App\Http\Controllers\FrontControllers\PageController::class, 'pressrelease'])->name('pressrelease');











Route::get('/', function () {
    return redirect(app()->getLocale());
});


Route::prefix('admin')->group( function () {
    Auth::routes();
});

// website home page 
Route::group([
    'prefix' => '{locale}', 
    'where' => ['locale' => '[a-zA-Z]{2}'], 
    'middleware' => 'setlocale',
], function() {

    Route::get('/' ,[App\Http\Controllers\FrontControllers\PageController::class, 'homepage'])->name('homepage');
    Route::get('/events-ajax', [App\Http\Controllers\AdminControllers\events_main::class, 'fetchevent'])->name('fetch_event');
});

