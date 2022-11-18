<?php

namespace App\Http\Controllers\Admincontrollers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class profile_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function userupdateform($id)
    {
        $data =  Profile::where('id' , $id)->get(); 
        $area = json_decode($data, true);
            return view('admin.Profile.update', compact('area'));
            
    }
    public function nameupdate(Request $request , $id)
    {

         $request->validate([
        'name' => 'required',
        'email' => 'required'
    ]);
    $profile = new Profile;
    $name = $request->input('name');
    $email = $request->input('email');
    $profile->whereId($id)->update(array('name'=>$name,'email'=>$email));
    return redirect()->route('useruserupdate', $id)->with('message', 'Profile Successfully Updated');
}
    public function updateform($id)
    {
        $data =  Profile::where('id' , $id)->get(); 
        $area = json_decode($data, true);
            return view('admin.Profile.pass_update', compact('area'));
            
    }

    // password
    public function update(Request $request , $id)
    {

         $request->validate([
        'current_password' => 'required',
        'new_password' => 'required',
        'confirm_password' => 'required',
    ]);
        
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');
        $password = Hash::make($new_password);
       
        if(Hash::check($current_password, Auth::user()->password)){
        if($current_password == $new_password)
        {
            return redirect()->back()->withErrors('New Password and current password are same');
        }
        else{
            if($new_password == $confirm_password)
            {
                $affected = Profile::where('id', $id)
                ->update(array('password' => $password));

                return redirect()->back()->with('message','Password Updated Successfully');
            }
    else
    {
        return redirect()->back()->withErrors('password dont match');
        
    }
}

}
else
{
    return redirect()->back()->withErrors('Invalid Password');
}
    }
    
    
}