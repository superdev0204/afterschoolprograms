<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use ReCaptcha\ReCaptcha;
use App\Models\Afterschools;
use App\Models\Activity;
use App\Models\Reviews;

class ReviewController extends Controller
{
    public function comment(Request $request)
    {
        $user = Auth::user();
        
        if (!$request->commentableId ||
            !in_array($request->commentableType, ['afterschool', 'activity'])
        ) {
            return redirect('/');
        }

        if ($request->commentableType == 'activity') {
            $activity = Activity::where('id', $request->commentableId)->first();
        } else {
            $afterschool = Afterschools::where('id', $request->commentableId)->first();
        }

        $method = $request->method();
        $message = 'Please complete the review form below and submit';
        $review = [];
        $rating = [1 => 'Review - 1 star', 2 => 'Review - 2 star', 3 => 'Review - 3 star', 4 => 'Review - 4 star', 5 => 'Review - 5 star'];

        if ($method == "POST") {
            $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
            $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

            $withErrors = [];
            if(!$request->rating){
                $withErrors['rating'] = 'The rating field is required';
            }

            if(!$request->comments){
                $withErrors['comments'] = 'The comments field is required';
            }

            if(!isset($user->type)){
                if ($response->isSuccess()) {
                    // reCAPTCHA verification successful, process the form submission
                }
                else{
                    $withErrors['recaptcha-token'] = 'The recaptcha-token field is required.';
                }

                if(!$request->email){
                    $withErrors['email'] = 'The email field is required';
                }

                if(!$request->reviewBy){
                    $withErrors['reviewBy'] = 'The reviewBy field is required';
                }

                if($request->reviewBy && strlen($request->reviewBy) < 5){
                    $withErrors['reviewBy'] = 'The reviewBy field must be at least 5 characters.';
                }
            }

            if(count($withErrors) > 0){
                if ($request->commentableType == 'activity') {
                    return view('review', compact('user', 'review', 'message', 'request', 'rating', 'activity'))->withErrors($withErrors);
                } else {
                    return view('review', compact('user', 'review', 'message', 'request', 'rating', 'afterschool'))->withErrors($withErrors);
                }
            }
            
            if(!isset($user->type)){
                $review = Reviews::create([
                    'commentable_id' => $request->commentableId,
                    'commentable_type' => $request->commentableType,
                    'review_by' => $request->reviewBy,
                    'email' => $request->email,
                    'rating' => $request->rating,
                    'comments' => $request->comments,
                    'approved' => 0,
                    'owner_comment' => '',
                    'helpful' => 0,
                    'nohelp' => 0,
                    'email_verified' => 0,
                    'ip_address' => request()->ip()
                ]);
            }
            else{
                $review = Reviews::create([
                    'commentable_id' => $request->commentableId,
                    'commentable_type' => $request->commentableType,
                    'user_id' => $user->id,
                    'review_by' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'rating' => $request->rating,
                    'comments' => $request->comments,
                    'approved' => 0,
                    'ip_address' => request()->ip(),
                    'email_verified' => 1,
                    'owner_comment' => '',
                    'helpful' => 0,
                    'nohelp' => 0,
                ]);

                if($user->type == "ADMIN"){
                    $review->approved = 1;
                    $review->save();
                }
            }

            if (!isset($user->type)) {
                try {
                    $name = isset($activity) ? $activity->name : $afterschool->name;
                    
                    if ($review->commentable_type == 'activity') {
                        $subject = 'Your Review for ' . $name;

                    } else {
                        $subject = 'Your Review for ' . $name;
                    }
                    
                    $message = "
                    Hello, <br/><br/>
                    We received the following review for {$name}:<br/>
                    ----------<br/>
                    {$review->review_text}<br />
                    ----------<br/><br/>
                    To verify that you are the person submitted the review above, please follow this link:<br/><br/>
                    <a href='{$request->getSchemeAndHttpHost()}/review/verify/{$review->id}/{$review->commentable_id}'>{$request->getSchemeAndHttpHost()}/review/verify/{$review->id}/{$review->commentable_id}</a><br/><br/>
                    If you are unable to click on the link above, copy and paste the full link into your web browser's address bar and press enter. <br/><br/>
                    Thanks sincerely
                    ";

                    $data = array(
                        'from_name' => config('mail.from.name'),
                        'from_email' => config('mail.from.address'),
                        'subject' => $subject,
                        'message' => $message,
                    );
                    
                    Mail::to($request->email)->send(new SendEmail($data));
                } catch (\Exception $e) {
                    $message = $e;
                    if ($request->commentableType == 'activity') {
                        return view('review', compact('user', 'review', 'message', 'request', 'rating', 'activity'));
                    } else {
                        return view('review', compact('user', 'review', 'message', 'request', 'rating', 'afterschool'));
                    }
                }
            }

            $message = 'Thank you for your comment. <br/><br/>';

            if (!isset($user->type)) {
                $message .= 'A confirmation has been sent to ' . $review->email . '. Please check your email and click on the confirmation link before the review is published.<br/><br/>';
                $message .= 'If your email address is not ' . $review->email . ' or if you think you have made an error, please hit the back button on your browser to correct and resubmit your form. <br/>';
            }

            if (isset($activity)) {
                $message .= "<br/> <a href='/'>Return to listing details</a>";
            } else {
                $message .= "<br/> <a href='/program-{$afterschool->id}-{$afterschool->filename}.html'>Return to listing details</a>";
            }
        }

        if ($request->commentableType == 'activity') {
            return view('review', compact('user', 'review', 'message', 'request', 'rating', 'activity'));
        } else {
            return view('review', compact('user', 'review', 'message', 'request', 'rating', 'afterschool'));
        }
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        $reviewId = request()->route()->parameter('id');
        $commentableId = request()->route()->parameter('commentableId');
        
        $review = Reviews::where('id', $reviewId)
                        ->where('commentableId', $commentableId)
                        ->first();
        
        if (!$review) {
            return redirect('/');
        }

        $review->email_verified = true;
        $review->save();

        if ($review->commentable_type == 'activity') {
            $activity = Activity::where('id', $commentableId)->first();
            return view('review_verify', compact('user', 'review', 'activity'));
        } else {
            $afterschool = Afterschools::where('id', $commentableId)->first();
            return view('review_verify', compact('user', 'review', 'afterschool'));
        }
    }
}
