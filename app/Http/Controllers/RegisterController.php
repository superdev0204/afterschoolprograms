<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use ReCaptcha\ReCaptcha;
use App\Models\User;
use App\Models\Afterschools;
use App\Models\Activity;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            return redirect('/');
        }

        $program = [];
        if (request()->query('id')) {
            if(request()->query('type') == 'afterschool'){
                /** @var Afterschools $program */
                $program = Afterschools::where('id', request()->query('id'))->first();
            }
            else{
                /** @var Activity $program */
                $program = Activity::where('id', request()->query('id'))->first();
            }
        }
        
        $method = $request->method();
        $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        $message = "";
        $new_user = null;

        if ($method == "POST") {
            $valid_item = [
                'type' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
                'firstName' => 'required|min:2',
                'lastName' => 'required|min:2',                
                'type' => 'required'
            ];

            if ($response->isSuccess()) {
                // reCAPTCHA verification successful, process the form submission
            }
            else{
                $valid_item['recaptcha-token'] = 'required';
            }

            $validated = $request->validate($valid_item);

            $push_data = [];

            if (request()->query('id')) {
                if ($program) {
                    $push_data["program_id"] = $program->id;
                    $push_data["program_type"] = request()->query('type');
                }
                else{
                    $push_data["program_id"] = 0;
                    $push_data["program_type"] = "";
                }
            }
            else{
                $push_data["program_id"] = 0;
                $push_data["program_type"] = "";
            }

            $push_data["first_name"] = $request->firstName;
            $push_data["last_name"] = $request->lastName;
            $push_data["email"] = $request->email;
            $push_data["created_at"] = new \DateTime();
            $push_data["updated_at"] = new \DateTime();
            $push_data["password"] = bcrypt($request->password);
            $push_data["ip_address"] = request()->ip();
            $push_data["type"] = $request->type;
            $push_data["status"] = false;
            $push_data["resetcode"] = rand(1000001, 99999999);
            $push_data["attempt"] = 0;
            $push_data["logintime"] = 0;

            $new_user = User::create($push_data);

            if($new_user){
                try {
                    $link = $request->getSchemeAndHttpHost() . '/user/activate?id=' . $new_user->id . '&secret=' . $new_user->resetcode;
                    $message = 'Please click on the link below to activate your AfterSchoolPrograms.org account. <br /><br />';
                    $message .= '<a href="' . $link . '">' . $link . '</a>';
                    
                    $data = array(
                        'from_name' => config('mail.from.name'),
                        'from_email' => config('mail.from.address'),
                        'subject' => 'AfterSchoolPrograms.org Registration E-Mail Validation',
                        'message' => $message,
                    );
    
                    Mail::to($request->email)->send(new SendEmail($data));
    
                    $message = 'Thank you for registering.  Your information was successfully saved. <br/> ';
                    $message .= 'Please check your email ' . $request->email . ' for information to activate your account.';
                    $message .= '<br/> If you do not see an email from us, please <strong>check your Spam folder or Junk mail folder</strong>.';
                } catch (\Exception $e) {
                    $message = $e;
                }
            }
            else{
                $message = 'Please make the following corrections and submit again.';
            }
        }

        return view('register', compact('message', 'user', 'new_user', 'request', 'program'));
    }

    public function activate(Request $request)
    {
        $id = $request->id;
        $secret = $request->secret;

        if (!$id || !$secret) {
            return redirect('/');
        }

        /** @var User $user */
        $user = User::where('id', $id)
                    ->where('resetcode', $secret)
                    ->first();

        if (!$user) {
            return redirect('/');
        }

        $user->status = 1;
        $user->save();

        return redirect('/user/login');
    }
}
