<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplainForm;
use Yajra\Datatables\Datatables;
use Mail;

class ComplainController extends Controller
{
    public function ajaxdata(Request $request)
    {
            $data = ComplainForm::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('action', function($row){
                    $actionBtn = '<form action="complain/delete/' . $row->id . '" method="GET">
                    '.csrf_field().'
                    '.method_field("GET").'
                    <button type="submit" class="delete btn btn-danger btn-sm tuc_name-white" onclick="return confirm(\'Are you sure you want to Delete ?\')"
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
        $complain = ComplainForm::all();
        return view('admin.complain.index', compact('complain'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'first_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $complain = new ComplainForm;
        $complain->name = $request->input('name');
        $complain->first_name = $request->input('first_name');
        $complain->phone_number = $request->input('phone_number');
        $complain->email = $request->input('email');
        $complain->message = $request->input('message');
         $data = [
          'name' => $request->name,
          'email' => $request->email,
          'first_name' => $request->first_name,
          'phone_number' => $request->phone_number,
          'messager' => $request->message
        ];
           Mail::send('admin.email',$data, function($messages) use ($data) {
         $messages->to('complaints@dmcsouth.gos.pk','DMC South')->subject('Complain');
         $messages->from('complaints@dmcsouth.gos.pk','DMC South');
      });
        $complain->save();
        return redirect()->back()->with('message', 'complain successfully Added'); 
    }
  
    public function delete($id)
    {

        $complain = ComplainForm::find($id);
        $complain->delete($id);
        // SubMenu::where('main_menu_id',$id)->delete();
        return redirect()->back()->with('message', 'complain successfully Deleted');
    }
}
