<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Afterschools;
use App\Models\Activity;
use ReCaptcha\ReCaptcha;

class QuestionController extends Controller
{
    public function send_question(Request $request)
    {
        $user = Auth::user();
        
        $method = $request->method();
        $message = 'You can leave a message using the form below.';
        
        $programId = $request->id;
        $programType = $request->type;

        if ((!$programId || !$programType) && !$request->page_url) {
            return redirect('/');
        }

        $program = [];
        $page_url = "";

        if ($programId) {
            if($programType == 'afterschool'){
                $program = Afterschools::where('id', $programId)->first();
            }
            else{
                $program = Activity::where('id', $programId)->first();
            }

            if (!$program) {
                return redirect('/');
            }
        }

        if ($request->page_url) {
            $page_url = $request->page_url;
        }
        
        if ($method == "POST") {
            $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
            $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

            $valid_item = [
                'question' => 'required'
            ];

            if(!$user){
                $valid_item['userName'] = 'required|min:3';
                $valid_item['userEmail'] = 'required';
                if ($response->isSuccess()) {
                    // reCAPTCHA verification successful, process the form submission
                }
                else{
                    $valid_item['recaptcha-token'] = 'required';
                }
            }

            $validated = $request->validate($valid_item);

            $push_data = [
                'question' => strip_tags($request->question),
                'approved' => '0'
            ];

            if(isset($user->type)){
                $push_data['user_id'] = $user->id;
                $push_data['question_by'] = $user->first_name . ' ' . $user->last_name;
                $push_data['question_email'] = $user->email;
            }
            else{
                $push_data['question_by'] = $request->userName;
                $push_data['question_email'] = $request->userEmail;
            }

            if ($programId) {
                $push_data['program_id'] = $programId;
            }

            if ($programType) {
                $push_data['program_type'] = $programType;
            }

            if ($request->page_url) {
                $push_data['page_url'] = $request->page_url;
            }

            $question = Questions::create($push_data);

            $message = 'Your question is successfully save.  It will be displayed after we review and approve your question.';
        }

        return view('question', compact('program', 'programType', 'page_url', 'user', 'message', 'request'));
    }

    public function send_answer(Request $request)
    {
        $user = Auth::user();

        $method = $request->method();
        $message = 'You can leave a message using the form below.';
        
        $programId = $request->id;
        $programType = $request->type;
        $questionId = $request->questionId;

        if (((!$programId || !$programType) && !$request->page_url) || !$questionId) {
            return redirect('/');
        }

        $program = [];
        $page_url = "";

        if ($programId) {
            if($programType == 'afterschool'){
                $program = Afterschools::where('id', $programId)->first();
            }
            else{
                $program = Activity::where('id', $programId)->first();
            }

            if (!$program) {
                return redirect('/');
            }
        }

        if ($request->page_url) {
            $page_url = $request->page_url;
        }

        $question = Questions::where('id', $questionId)->first();

        if (!$question) {
            return redirect('/');
        }

        if ($method == "POST") {
            $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
            $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

            $valid_item = [
                'answer' => 'required'
            ];

            if(!$user){
                $valid_item['answer_userName'] = 'required|min:3';
                $valid_item['answer_userEmail'] = 'required';
                if ($response->isSuccess()) {
                    // reCAPTCHA verification successful, process the form submission
                }
                else{
                    $valid_item['recaptcha-token'] = 'required';
                }
            }

            $validated = $request->validate($valid_item);

            $push_data = [
                'question_id' => $questionId,
                'answer' => strip_tags($request->answer),
                'approved' => '0'
            ];

            if(isset($user->type)){
                $push_data['user_id'] = $user->id;
                $push_data['answer_by'] = $user->first_name . ' ' . $user->last_name;
                $push_data['answer_email'] = $user->email;
            }
            else{
                $push_data['answer_by'] = $request->answer_userName;
                $push_data['answer_email'] = $request->answer_userEmail;
            }

            if ($programId) {
                $push_data['program_id'] = $programId;
            }

            if ($programType) {
                $push_data['program_type'] = $programType;
            }

            if ($request->page_url) {
                $push_data['page_url'] = $request->page_url;
            }

            $answer = Answers::create($push_data);

            $message = 'Your answer is successfully save.  It will be displayed after we review and approve your answer.';
        }

        return view('answer', compact('program', 'programType', 'page_url', 'question', 'user', 'message', 'request'));
    }
}
