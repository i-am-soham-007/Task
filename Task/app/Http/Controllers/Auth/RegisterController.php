<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Jobs\SendVerificationEmail;
//use App\Http\Controllers\Auth\Mail;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected $user;
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $this->validator($data)->validate();


        return User::create(['firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'email_token' => base64_encode($data['email']),
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'profile_path' => $path = public_path().'/profile/',
            'profile' =>  $data['image'],
            'verified' => 0]);

    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public  function  register(Request $request)
    {
        $this->validator($request->all())->validate();

        //event(new Registered($user = $this->create($request->all())));
        //dispatch(new SendVerificationEmail($user));


            $array['firstname'] =$request->firstname;
            $array['lastname'] =$request->lastname;
            $array['email'] =$request->email;
            $array['email_token'] =base64_encode($request->email);
            $array['password'] =bcrypt($request->password);
            $array['phone'] =$request->phone;
            $array['profile_path'] =$request->phone;
        if(isset($request->image)){
            $array['profile'] =$request->phone;
        }

            $array['verified'] =0;
        User::create($array);


        $to_name = $request->firstname." ".$request->lastname;
        $to_email = $request->email;//'rsoham00@gmail.com';
        $email_token = base64_encode($request->email);
        $data = array('name' => 'danosd (sender_name)', 'body' => 'A test mail', 'email_token' => $email_token);
        $mail = Mail::send('email.email', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Verify Account');
            $message->from('developer.project2021@gmail.com', 'Verify Account');
        });

        if($mail){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Check email to verify account!');

            return view('verification')->with(compact('email_token'));
        }else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Something went wrong');
            return view('verification')->with(compact('email_token'));
        }

    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
        
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->verified = "1";
        if($user->save()){
            return view('emailconfirm',['user'=>$user]);
        }
    }
    public function imageUpload(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($validation->passes())
        {
            $path = 'profile/';
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

    public function checkMail()
    {
        $to_name = 'soham';
        $to_email = 'rsoham00@gmail.com';
        $data = array('name' => 'danosd (sender_name)', 'body' => 'A test mail', 'email_token' => "");
        Mail::send('email.email', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Laravel Test Mail');
            $message->from('developer.project2021@gmail.com', 'Test Mail');
        });
    }

public function show(){
        return view('user.test');
}
public function userlist(){
        $users = User::all();
    return view('user.table')->with(compact('users'));
}

//    public function test(){
//        return view('user.test');
//    }
}
