<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enviroment;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class EnviromentController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = Enviroment::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="enviroment/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="enviroment/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm text-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
                        ><i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                    </form> </div>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $enviroment = Enviroment::all();
        return view('admin.enviroment.index', compact('enviroment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.enviroment.add');
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

            'description' => 'required',
            'file' => 'required',

        ]);

        $enviroment = new enviroment;
        $enviroment->description = $request->input('description');
        $enviroment->file = $request->input('file');
        if($request->hasfile('file')) 
        {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/enviroment/pdf', $filename);
            $enviroment->file =$filename;
        }
        $enviroment->save();
        return redirect()->back()->with('message', 'Budget Book successfully Added'); 
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
        $enviroment = Enviroment::find($id);
         return view('admin.enviroment.edit', compact('enviroment'));
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

            'description' => 'required',

        ]);

        $enviroment = Enviroment::find($id);
        $enviroment->description = $request->input('description');
        if($request->hasfile('file')) 
        {
            $destination = 'uploads/enviroment/' .$enviroment->file;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/enviroment/pdf', $filename);
            $enviroment->file =$filename;
        }
        $enviroment->save();
        return redirect()->back()->with('message', 'Budget Book successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $enviroment = Enviroment::find($id);
        $enviroment->delete($id);
        return redirect()->back()->with('message', 'Budget Book successfully Deleted');
    }
}
