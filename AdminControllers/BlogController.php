<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Ajax datatables function
    public function ajaxdata(Request $request)
    {
            $data = Blog::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center"> <a href="blog/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="blog/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';
                    return $actionBtn;
                    
                })
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->editColumn('featured_img', function($row){
                    $url=asset("uploads/blog/$row->featured_img");
                    $image = '<img src='.$url.' width="130px">' ;
                     return $image;
                })
                ->editColumn('lang_id', function($row){
                    $en = '<span class="bg-success text-white p-2" style="display: inline-block; font-size: .875rem;">English</span>';
                    $ur = '<span class="bg-info text-white p-2" style="display: inline-block; font-size: .875rem;">Urdu</span>';
                    $si = '<span class="bg-warning p-2" style="display: inline-block; font-size: .875rem; color: #fff !important;">Sindhi</span>';
                    
                    $lang_id = [1 => $en, 2 => $ur, 3 => $si];
                    return $lang_id[$row->lang_id];
                })
                ->editColumn('status', function($row){
                    $active = '<form action="/admin/blog_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                   <button class="btn btn-success text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Active
                        </button>
                    </form>';
                    $inactive = '<form action="/admin/blog_status/' . $row->id . '" method="POST">
                    '.csrf_field().'
                    '.method_field("POST").'
                     <button class="btn btn-danger text-white p-2 btn-sm" onclick="return confirm(\'Are you sure you want to update Status ?\')"
                        style="padding: 7px !important;font-size: .875rem; ">Inactive
                        </button>
                    </form>';
                    $status = [0 => $inactive, 1 => $active];
                    return $status[$row->status];
                })
                
                ->rawColumns(['action', 'created_at' , 'lang_id', 'status', 'featured_img' ])
                ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::all();
        return view('admin.Blog.index', compact('blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.Blog.add');
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

            'title' => 'required',
            'description' => 'required',
            'btn_title' => 'required',
            'date' => 'required',
            'featured_img' => 'required',
            'description_image' => 'required',
            

        ]);

        // dd($request);
        $blog = new Blog;
        $blog->title = $request->input('title');
        $blog->slug = Str::slug($request->input('title'), '-');
        $blog->description = $request->input('description');
        $blog->long_description = $request->input('long_description');
        $blog->featured_img = $request->input('featured_img');
        $blog->btn_title = $request->input('btn_title');
        $blog->is_long_desc = $request->input('is_long_desc');
        $blog->date = $request->input('date');
        $blog->lang_id = $request->input('lang_id');
        $blog->status = $request->input('status');
        if($request->hasfile('featured_img')) 
        {
            $file = $request->file('featured_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.mt_rand(1,9999999).'.'.$extention;
            $file->move('uploads/blog/', $filename);
            $blog->featured_img =$filename;
        }
        if($request->hasfile('description_image')) 
        {
            $file = $request->file('description_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.mt_rand(1,9999999).'.'.$extention;
            $file->move('uploads/blog/', $filename);
            $blog->description_image =$filename;
        }
        $blog->status = $request->input('status') == true ? '1':'0';
        $blog->save();
        return redirect()->back()->with('message', 'Blog successfully Added');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('admin.Blog.edit', compact('blog'));
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

            'title' => 'required',
            'description' => 'required',
            'btn_title' => 'required',
            'date' => 'required',

        ]);
        
        //dd($request);
        $blog = Blog::find($id);
        $blog->title = $request->input('title');
        $blog->slug = Str::slug($request->input('title'), '-');
        $blog->description = $request->input('description');
        $blog->long_description = $request->input('long_description');
        $blog->btn_title = $request->input('btn_title');
        $blog->is_long_desc = $request->input('is_long_desc');
        $blog->date = $request->input('date');
        $blog->lang_id = $request->input('lang_id');
        $blog->status = $request->input('status');
        if($request->hasfile('featured_img')) 
        {
            
            $destination = 'uploads/blog/' .$blog->featured_img;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $request->file('featured_img');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.mt_rand(1,9999999).'.'.$extention;
            $file->move('uploads/blog/', $filename);
            $blog->featured_img = $filename;
            
        }
        if($request->hasfile('description_image')) 
        {
            
            $destination = 'uploads/blog/' .$blog->description_image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $request->file('description_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.mt_rand(1,9999999).'.'.$extention;
            $file->move('uploads/blog/', $filename);
            $blog->description_image = $filename;
            
        }
        
        $blog->status = $request->input('status') == true ? '1':'0';
        $blog->save();
        
        return redirect()->back()->with('message', 'Blog successfully Update'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $blog = Blog::find($id);
        $image = $blog['featured_img'];
        $path = public_path()."/uploads/blog/".$image;
            if(File::exists($path)) {
                File::delete($path);
            }

        $blog->delete($id);
        return redirect()->back()->with('message', 'Blog successfully Delete');
    }


    // status pop up 
    public function statusUpdate($id)
    {   
        $data =  Blog::where('id' , $id )->get('status'); 
        $area = json_decode($data, true);
        if($area[0]['status'] == 0)
        {
        $affected = Blog::where('id', $id)
                ->update(array('status' => 1));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
        else
        {
            $affected = Blog::where('id', $id)
                ->update(array('status' => 0));
                return redirect()->back()->with('message', 'Status Updated Successfully');
        }
    }
}
