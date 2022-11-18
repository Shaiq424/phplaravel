<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeLicense;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class TradeController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = TradeLicense::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<div class="action_btns d-flex justify-content-center">  <a href="tradelicense/edit/'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                    
                    <form action="tradelicense/delete/' . $row->id . '" method="GET">
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
        $tradelicense = TradeLicense::all();
        return view('admin.tradelicense.index', compact('tradelicense'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('admin.tradelicense.add');
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

        $tradelicense = new tradelicense;
        $tradelicense->description = $request->input('description');
        $tradelicense->file = $request->input('file');
        if($request->hasfile('file')) 
        {
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/tradelicense/pdf', $filename);
            $tradelicense->file =$filename;
        }
        $tradelicense->save();
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
        $tradelicense = TradeLicense::find($id);
         return view('admin.tradelicense.edit', compact('tradelicense'));
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

        $tradelicense = TradeLicense::find($id);
        $tradelicense->description = $request->input('description');
        if($request->hasfile('file')) 
        {
            $destination = 'uploads/tradelicense/' .$tradelicense->file;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extention;
            $file->move('uploads/tradelicense/pdf', $filename);
            $tradelicense->file =$filename;
        }
        $tradelicense->save();
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
        $tradelicense = TradeLicense::find($id);
        $tradelicense->delete($id);
        return redirect()->back()->with('message', 'Budget Book successfully Deleted');
    }
}
