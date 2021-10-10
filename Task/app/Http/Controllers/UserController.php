<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addUser(){
        return view('user.test');
    }
    public function show(){
        $users = User::all();
        return view('user.table')->with(compact('users'));
    }
    public function create(Request $request){

        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required',
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $user = User::create(['firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'email_token' => base64_encode($request->email),
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'profile_path' => $path = public_path().'/profile/',
            'profile' =>  $request->image,
            'verified' => 0]);

        if($user){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'New user added!');

            return redirect('user-list');
        }else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Something went wrong');
            return redirect('user-list');
        }
    }

    public function imageUpload(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($validation->passes())
        {
            $path = public_path().'/profile/';
            $image = $request->file('select_file');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $new_name);
            $path = $path.$new_name;
            return response()->json([
                'message'   => 'Image Upload Successfully',
                'uploaded_image' => '<img src="'.$path.'" class="img-thumbnail" width="150" height="150"/>',
                'class_name'  => 'alert-success',
                'image_name' =>$new_name
            ]);
        }
        else
        {
            return response()->json([
                'message'   => $validation->errors()->all(),
                'uploaded_image' => '',
                'class_name'  => 'alert-danger'
            ]);
        }
    }
    public function dashboard(){
        return view('dashboard');
    }
    public function profile($id){
        $user = User::find($id);
        return view('user.profile')->with(compact('user'));
    }

    public function updateProfile(Request $request,$id){

        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required|numeric'
        ]);

        $array['firstname'] = $request->firstname;
        $array['lastname'] = $request->lastname;
        $array['phone'] = $request->phone;
        if(isset($request->imageName)){
            $array['profile'] = $request->imageName;
        }


        $user = User::where('id',$id)->update($array);

        if($user){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'User profile update succesfully!');

            return redirect('user-list');
        }else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Something went wrong');
            return redirect('user-list');
        }
    }

    public function deleteUser($id){
        $user = User::where('id',$id)->delete();
        if($user){
            session()->flash('message.level', 'success');
            session()->flash('message.content', 'User deleted succesfully!');

            return redirect('user-list');
        }else{
            session()->flash('message.level', 'danger');
            session()->flash('message.content', 'Something went wrong');
            return redirect('user-list');
        }

    }
}
