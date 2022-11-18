<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Headings;
use Yajra\Datatables\Datatables;

class contact_us extends Controller
{
    
   
    // Ajax datatables function
    public function ajaxdata(Request $request)
    {
            $data = Contact::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<a href="contact/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    return $actionBtn;
                })
                ->editColumn('updated_at', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->rawColumns(['action', 'lang_id', 'updated_at'])
                ->make(true);
    }

       public function index()
    {
        $headings = Headings::where('type_id', 8)->get();
        $contact = Contact::all();
        return view('admin.Pages.Contact.index', compact('contact','headings'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        
        return view('admin.Pages.Contact.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            
            'iframe_link' => 'required',
            'placeholder_name' => 'required',
            'placeholder_fullname' => 'required',
            'placeholder_phone_number' => 'required',
            'placeholder_email' => 'required',
            'placeholder_message' => 'required',
            'btn_title' => 'required',
        ]);

        $contact = new Contact;
        $contact->iframe_link = $request->input('iframe_link');
        $contact->placeholder_name = $request->input('placeholder_name');
        $contact->placeholder_fullname = $request->input('placeholder_fullname');
        $contact->placeholder_phone_number = $request->input('placeholder_phone_number');
        $contact->placeholder_email = $request->input('placeholder_email');
        $contact->placeholder_message = $request->input('placeholder_message');
        $contact->btn_title = $request->input('btn_title');
        $contact->lang_id = $request->input('lang_id');
        $contact->save();
        return redirect()->back()->with('message', 'Contact Us Content successfully Added'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
         return view('admin.pages.Contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'iframe_link' => 'required',
            'placeholder_name' => 'required',
            'placeholder_fullname' => 'required',
            'placeholder_phone_number' => 'required',
            'placeholder_email' => 'required',
            'placeholder_message' => 'required',
            'btn_title' => 'required',

        ]);
        
        $contact = Contact::find($id);
        $contact->iframe_link = $request->input('iframe_link');
        $contact->placeholder_name = $request->input('placeholder_name');
        $contact->placeholder_fullname = $request->input('placeholder_fullname');
        $contact->placeholder_phone_number = $request->input('placeholder_phone_number');
        $contact->placeholder_email = $request->input('placeholder_email');
        $contact->placeholder_message = $request->input('placeholder_message');
        $contact->btn_title = $request->input('btn_title');
        $contact->lang_id = $request->input('lang_id');
        $contact->save();
        return redirect()->back()->with('message', 'Contact Us Content successfully Updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete($id);
        return redirect()->back()->with('message', 'Contact Us Content successfully Deleted');
    }


}
