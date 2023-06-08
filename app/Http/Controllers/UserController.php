<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Network;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Share;

class UserController extends Controller
{
        // User Registration
    public function Register(){
        return view('auth.register');
    }

    public function RegisterUser(Request $req){
        $validate = Validator::make($req->all(),
        [
            'username' => 'required|string|min:3|max:25',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:3|max:15|confirmed',
            // 'cnf_password' => 'required',
        ],
        [
            'username.required' => 'Username field is required?',
            'username.string' => 'Username Accept only characters. Not a number or white space!',
            'username.min' => 'Username Accept Mininum 3 characters long!',
            'username.max' => 'Username Accept Maximum 25 character long!',
            'email.required' => 'Email field is required?',
            'email.email' => 'Enter a valid email address',
            'email.max' => 'Email Accept Maximum 25 character long!',
            'email.unique' => 'This email already taken',
            'password.required' => 'Password field is required?',
            'password.min' => 'Password Accept Mininum 3 characters long!',
            'password.max' => 'Password Accept Maximum 15 characters long!',
            'password.confirmed' => 'Confirm Password does not match with Password!',
            // 'cnf_password.required' => 'Confirm Password field is required?',
        ])->validate();

        $referral_code = Str::random(10);
        $token = Str::random(50);

        if (isset($req->referral_code)) {
            $userdata = User::where('referral_code',$req->referral_code)->get();
            if (count($userdata) > 0) {
                $user_id =  User::insertGetId([
                    'name' => $req->username,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                    'referral_code' => $referral_code,
                    'remember_token' => $token,
                ]);
                Network::insert([
                    'referral_code' => $req->referral_code,
                    'user_id' => $user_id,
                    'user_name' => $req->username,
                    'parent_user_id' => $userdata[0]['id'],
                    'parent_user_name' => $userdata[0]['name'],
                ]);
            }else{
                return back()->with(['error'=> 'Please Enter a valid referal code.']);
            }
        }else{
            User::insert([
                'name' => $req->username,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'referral_code' => $referral_code,
                'remember_token' => $token,
            ]);
        }
            // Verification Referral code
        $domain = URL::to('/');
        $url = $domain.'/referral-register?refe='.$referral_code;
        // dd($url);
        $data['url'] = $url;
        $data['name'] = $req->username;
        $data['email'] = $req->email;
        $data['password'] = $req->password;
        $data['title'] = 'Registered';

        Mail::send('mails.registermail',['data'=> $data], function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
        });

            // Email Verification
        $url = $domain.'/email-verification/'.$token;
        $data['url'] = $url;
        $data['name'] = $req->username;
        $data['email'] = $req->email;
        $data['title'] = 'Referral verification link';

        Mail::send('mails.verifymail',['data'=> $data], function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
        });

        return back()->with(['success'=> 'Registration has been successfull & Please verify your email']);
    }

            // Email Verification
    public function EmailVerification($token){
        $userdata = User::where('remember_token',$token)->get();
        $pathurl = URL::to('/');
        $loginurl = $pathurl.'/register';
        if (count($userdata) > 0) {
            if ($userdata[0]['is_verified'] == 1) {
                return view('auth.verifieduser',['message' => 'Your email is already verified.','url'=> $loginurl]);
            }
            User::where('id', $userdata[0]['id'])->update([
                'is_verified' => 1,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
            return view('auth.verifieduser',['message' => 'Your ' .$userdata[0]['email']. 'email verified successfully','url'=> $loginurl]);
        }else{
            return view('auth.verifieduser',['message' => 'File not found']);
        }
    }

            // Referral Registration
    public function ReferralRegister(Request $req){
        if (isset($req->refe)) {
            $referral_value = $req->refe;
            $userdata = User::where('referral_code',$referral_value)->get();
            if (count($userdata) > 0) {
                return view('auth.referralregister',compact('referral_value'));
            }else{
                return view('errors.404');
            }
        }else{
            return redirect('/register');
        }
    }

            // Login User

    public function Login(){
        return view('auth.login');
    }
    public function LoginUser(Request $req){
        $validate = Validator::make($req->all(),
        [
            'email' => 'required|email|max:50',
            'password' => 'required|min:3',
        ],
        [
            'email.required' => 'Email field is required?',
            'email.email' => 'Enter a valid email address',
            'email.max' => 'Email Accept Maximum 25 character long!',
            'password.required' => 'Password field is required?',
            'password.min' => 'Password Accept Mininum 3 characters long!',
            'password.max' => 'Password Accept Maximum 15 characters long!',
        ])->validate();

        $userdata = User::where('email',$req->email)->first();
        if (!empty($userdata)) {
            if ($userdata->is_verified == 0) {
                return back()->with(['error' => "Please Verify your Email..."]);
            }
        }else{
            return back()->with(['error' => "Your Email is not registered..."]);
        }

        $credenttial = $req->only('email','password');
        if (Auth::attempt($credenttial)) {
            return redirect('dashboard');
        }else{
            return back()->with(['error' => "Invalid Credenttial..."]);
        }
    }

             // Dashboad
    public function LoadDashboard(){
        $userpoints = Network::where('parent_user_id', Auth::user()->id)->orwhere('user_id',Auth::user()->id)->count();
        $childuserfromparents = Network::with('user')->where('parent_user_id', Auth::user()->id)->get();
        $url = URL::to('/').'/referral-register?refe='.Auth::user()->referral_code;
        $sharecomponents = Share::page($url,'Share and Earn Points by Referral Link')
        ->facebook()->twitter()->linkedin()->telegram()->whatsapp()->reddit();
        return view('auth.dashboard',compact(['userpoints','childuserfromparents','sharecomponents']));
    }
        // User Logout
    public function LogoutUser(Request $req){
        $req->session()->flush();
        Auth::logout();
        return redirect('login');
    }
            // Referral Track Line chart
    public function ReferralTrack(){
        $datelabels = [];
        $datedata = [];
        for ($i= 30; $i >= 0; $i--) {
            $datelabels[] = Carbon::now()->subDays($i)->format('d-m-Y');
            $dateformat = Carbon::now()->subDays($i)->format('Y-m-d');
            $datedata[] = Network::whereDate('created_at', $dateformat)->where('parent_user_id',Auth::user()->id)->count();
        }
        // echo "<pre>";
        // dd($datedata);
        // die;
        $datelabels = json_encode($datelabels);
        $datedata = json_encode($datedata);
        return view('auth.referraltrack',compact(['datelabels','datedata']));
    }
        // Delete Account
    public function DeleteAccount(Request $req){
        try {
            User::where('id', Auth::user()->id)->delete();
            $req->session()->flush();
            Auth::logout();
            return response()->json(['success'=> true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' =>$e->getMessage()]);
        }
    }
            // Load profile
    public function LoadProfile(Request $req){
        return view('auth.profile');
    }
            // Update profile
    public function ProfileUser(Request $req){
        $validate = Validator::make($req->all(),
        [
            'update_username' => 'required|string|min:3|max:25',
            'update_email' => 'required|email|max:50'
        ],
        [
            'update_username.required' => 'Username field is required?',
            'update_username.string' => 'Username Accept only characters. Not a number or white space!',
            'update_username.min' => 'Username Accept Mininum 3 characters long!',
            'update_username.max' => 'Username Accept Maximum 25 character long!',
            'update_email.required' => 'Email field is required?',
            'update_email.email' => 'Enter a valid email address',
            'update_email.max' => 'Email Accept Maximum 25 character long!',
        ])->validate();

        $update_input = array(
            'name' => $req->update_username,
            'email' => $req->update_email,
        );
        User::where('id', Auth::user()->id)->update($update_input);
        return redirect('dashboard')->with(['success'=> 'Your Profile Updated']);
    }
            // Change password
    public function ChangePassword(Request $req){
        $validate = Validator::make($req->all(),
        [
            'update_password' => 'required|min:3|max:15',
            'password' => 'required|min:3|max:15|confirmed',
        ],
        [
            'update_password.required' => 'Password field is required?',
            'update_password.min' => 'Password Accept Mininum 3 characters long!',
            'update_password.max' => 'Password Accept Maximum 15 characters long!',
            'password.required' => 'New Password field is required?',
            'password.min' => 'Password Accept Mininum 3 characters long!',
            'password.max' => 'Password Accept Maximum 15 characters long!',
            'password.confirmed' => 'Confirm Password does not match with New Password!',
        ])->validate();

        $user = User::findOrFail($req->hidden_password);
        if (Hash::check($req->update_password, Auth::user()->password)) {
            $user->fill([
                'password' => Hash::make($req->password),
            ])->save();
            $req->session()->flash('success','Password Changed Successfully.');
            return redirect()->route('profile.load');
        }else{
            $req->session()->flash('error','Password does not match');
            return redirect()->route('profile.load');
        }
    }
}
