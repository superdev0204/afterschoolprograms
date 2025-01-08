<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;
use App\Models\User;
use App\Models\Activity;
use App\Models\Activitylogs;
use App\Models\Reviews;
use App\Models\Images;
use App\Models\States;
use App\Models\Cities;
use App\Models\Counties;
use App\Models\Questions;
use App\Models\Answers;
use Carbon\Carbon;
use App\Services\BadWordService;

class ActivityController extends Controller
{
    protected $badWordService;

    public function __construct(BadWordService $badWordService)
    {
        $this->badWordService = $badWordService;
    }

    public function martialArts(Request $request)
    {
        $user = Auth::user();

        $activities = Activity::where('approved', 1)
                            ->where('details', '<>', '')
                            ->where('kids_program_url', '<>', '')
                            ->where('category', 'MARTIAL-ARTS')
                            ->orderByDesc('updated')
                            ->limit(5)
                            ->get();
        
        $states = States::where('country', 'US')->get();

        return view('martial_arts', compact('activities', 'states', 'user', 'request'));
    }

    public function martialArts_show(Request $request)
    {
        $user = Auth::user();
        
        $id = request()->route()->parameter('id');
        if (!$id) {
            return redirect('/');
        }

        $activity = Activity::where('id', $id)->first();
        
        if (!$activity) {
            return redirect('/');
        }

        if (!$activity->lat || !$activity->lng) {
            $coordinates = $this->geocode($activity->address, $activity->city , $activity->state, $activity->zip);

            if ($coordinates) {
                $coordinatesSplit = explode(",", $coordinates,2);
                $activity->lat = $coordinatesSplit[1];
                $activity->lng = $coordinatesSplit[0];
                $activity->save();
            }
            else{
                $activity->lat = 0;
                $activity->lng = 0;
            }
        }

        $activity->phone = $this->formatPhoneNumber($activity->phone);
        $activity->url = $this->formatURL($activity->url);

        // $program = Headstartprograms::where('id', $center->program_id)->first();

        $state = States::where('state_code', $activity->state)->first();

        $city = Cities::where('city', $activity->city)
                        ->where('state', $activity->state)
                        ->first();

        $reviews = Reviews::where('commentable_id', $activity->id)
                            ->where('commentable_type', 'activity')
                            ->where('approved', 1)
                            ->get();

        foreach($reviews as $review){
            $review->review_by = $this->badWordService->maskBadWords($review->review_by);
            $review->comments = $this->badWordService->maskBadWords($review->comments);
        }
        
        $images = Images::where('imageable_id', $activity->id)
                        ->where('imageable_type', 'activity')
                        ->where('approved', 1)
                        ->get();

        $programId = $activity->id;
        $questions = Questions::where(function($query) use ($programId) {
                            $query->where(function($query) {
                                $query->where('program_type', '')
                                    ->orWhereNull('program_type'); // Handling NULL condition
                            })
                            ->orWhere(function($query) {
                                $query->where('program_id', 0)
                                        ->where('program_type', 'martial_arts');
                            })
                            ->orWhere(function($query) use ($programId) {
                                $query->where('program_id', $programId)
                                        ->where('program_type', 'martial_arts');
                            });
                        })
                        ->where('approved', '1')
                        ->orderBy('created_at', 'desc')
                        ->get();
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                            ->where('program_id', $programId)
                            ->where('program_type', 'martial_arts')
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }
                            
        return view('martial_arts_show', compact('user', 'activity', 'state', 'city', 'images', 'reviews', 'questions'));
    }

    public function martialArts_state(Request $request)
    {
        $user = Auth::user();

        $stateName = request()->route()->parameter('statename');
        
        $state = States::where('statefile', $stateName)->first();

        if (!$state) {
            return redirect('/');
        }

        $cities = Cities::where('state', $state->state_code)
                        ->where('activities_count', '>', '0')
                        ->orderBy('city', 'asc')
                        ->get();

        $activities = Activity::where('approved', 1)
                            ->where('details', '!=', '')
                            ->where('kids_program_url', '!=', '')
                            ->where('category', 'MARTIAL-ARTS')
                            ->where('state', $state->state_code)
                            ->orderByDesc('updated')
                            ->limit(5)
                            ->get();

        $parsedUrl = parse_url(url()->current());
        // Get the path and query
        $page_url = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
        $questions = Questions::where(function($query) use ($page_url) {
                                $query->where(function($query) {
                                    $query->where('program_type', '')
                                        ->orWhereNull('program_type'); // Handling NULL condition
                                })
                                ->orWhere(function($query) {
                                    $query->where('program_id', 0)
                                            ->where('program_type', 'martial_arts');
                                })
                                ->orWhere('page_url', $page_url);
                            })
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                                ->where('page_url', $page_url)
                                ->where('approved', '1')
                                ->orderBy('created_at', 'desc')
                                ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }

        return view('martial_arts_state', compact('user', 'activities', 'state', 'cities', 'questions', 'page_url'));
    }

    public function martialArts_city(Request $request)
    {
        $user = Auth::user();

        $cityName = request()->route()->parameter('cityname');

        /** @var City $city */
        
        $city = Cities::where('filename', $cityName)->first();

        if (!$city) {
            return redirect('/');
        }

        /** @var State $state */
        $state = States::where('statefile', $city->statefile)->first();

        $activities = Activity::where('approved', 1)
                            ->where('category', 'MARTIAL-ARTS')
                            ->where('state', $state->state_code)
                            ->where('city', $city->city)
                            ->orderBy('name', 'asc')
                            ->get();

        $parsedUrl = parse_url(url()->current());
        // Get the path and query
        $page_url = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
        $questions = Questions::where(function($query) use ($page_url) {
                                $query->where(function($query) {
                                    $query->where('program_type', '')
                                        ->orWhereNull('program_type'); // Handling NULL condition
                                })
                                ->orWhere(function($query) {
                                    $query->where('program_id', 0)
                                            ->where('program_type', 'martial_arts');
                                })
                                ->orWhere('page_url', $page_url);
                            })
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                                ->where('page_url', $page_url)
                                ->where('approved', '1')
                                ->orderBy('created_at', 'desc')
                                ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }

        return view('martial_arts_city', compact('user', 'activities', 'state', 'city', 'questions', 'page_url'));
    }

    public function youthSports(Request $request)
    {
        $user = Auth::user();

        $activities = Activity::where('approved', 1)
                            ->where('details', '<>', '')
                            ->where('category', 'YOUTH-SPORTS')
                            ->orderByDesc('updated')
                            ->limit(5)
                            ->get();
        
        $states = States::where('country', 'US')->get();

        return view('youth_sports', compact('activities', 'states', 'user', 'request'));
    }

    public function youthSports_show(Request $request)
    {
        $user = Auth::user();
        
        $id = request()->route()->parameter('id');
        if (!$id) {
            return redirect('/');
        }

        $activity = Activity::where('id', $id)->first();
        
        if (!$activity) {
            return redirect('/');
        }

        if (!$activity->lat || !$activity->lng) {
            $coordinates = $this->geocode($activity->address, $activity->city , $activity->state, $activity->zip);

            if ($coordinates) {
                $coordinatesSplit = explode(",", $coordinates,2);
                $activity->lat = $coordinatesSplit[1];
                $activity->lng = $coordinatesSplit[0];
                $activity->save();
            }
            else{
                $activity->lat = 0;
                $activity->lng = 0;
            }
        }

        $activity->phone = $this->formatPhoneNumber($activity->phone);
        $activity->url = $this->formatURL($activity->url);

        // $program = Headstartprograms::where('id', $center->program_id)->first();

        $state = States::where('state_code', $activity->state)->first();

        $city = Cities::where('city', $activity->city)
                        ->where('state', $activity->state)
                        ->first();

        $reviews = Reviews::where('commentable_id', $activity->id)
                            ->where('commentable_type', 'activity')
                            ->where('approved', 1)
                            ->get();

        foreach($reviews as $review){
            $review->review_by = $this->badWordService->maskBadWords($review->review_by);
            $review->comments = $this->badWordService->maskBadWords($review->comments);
        }
        
        $images = Images::where('imageable_id', $activity->id)
                        ->where('imageable_type', 'activity')
                        ->where('approved', 1)
                        ->get();

        $programId = $activity->id;
        $questions = Questions::where(function($query) use ($programId) {
                            $query->where(function($query) {
                                $query->where('program_type', '')
                                    ->orWhereNull('program_type'); // Handling NULL condition
                            })
                            ->orWhere(function($query) {
                                $query->where('program_id', 0)
                                        ->where('program_type', 'youth_sports');
                            })
                            ->orWhere(function($query) use ($programId) {
                                $query->where('program_id', $programId)
                                        ->where('program_type', 'youth_sports');
                            });
                        })
                        ->where('approved', '1')
                        ->orderBy('created_at', 'desc')
                        ->get();
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                            ->where('program_id', $programId)
                            ->where('program_type', 'youth_sports')
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }
                            
        return view('youth_sports_show', compact('user', 'activity', 'state', 'city', 'images', 'reviews', 'questions'));
    }

    public function youthSports_state(Request $request)
    {
        $user = Auth::user();

        $stateName = request()->route()->parameter('statename');
        
        $state = States::where('statefile', $stateName)->first();

        if (!$state) {
            return redirect('/');
        }

        $cities = Cities::where('state', $state->state_code)
                        ->where('sports_count', '>', '0')
                        ->orderBy('city', 'asc')
                        ->get();

        $activities = Activity::where('approved', 1)
                            ->where('details', '!=', '')
                            ->where('category', 'YOUTH-SPORTS')
                            ->where('state', $state->state_code)
                            ->orderByDesc('updated')
                            ->limit(5)
                            ->get();

        $parsedUrl = parse_url(url()->current());
        // Get the path and query
        $page_url = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
        $questions = Questions::where(function($query) use ($page_url) {
                                $query->where(function($query) {
                                    $query->where('program_type', '')
                                        ->orWhereNull('program_type'); // Handling NULL condition
                                })
                                ->orWhere(function($query) {
                                    $query->where('program_id', 0)
                                            ->where('program_type', 'youth_sports');
                                })
                                ->orWhere('page_url', $page_url);
                            })
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                                ->where('page_url', $page_url)
                                ->where('approved', '1')
                                ->orderBy('created_at', 'desc')
                                ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }

        return view('youth_sports_state', compact('user', 'activities', 'state', 'cities', 'questions', 'page_url'));
    }

    public function youthSports_city(Request $request)
    {
        $user = Auth::user();

        $cityName = request()->route()->parameter('cityname');

        /** @var City $city */
        
        $city = Cities::where('filename', $cityName)->first();

        if (!$city) {
            return redirect('/');
        }

        /** @var State $state */
        $state = States::where('statefile', $city->statefile)->first();

        $activities = Activity::where('approved', 1)
                            ->where('category', 'YOUTH-SPORTS')
                            ->where('state', $state->state_code)
                            ->where('city', $city->city)
                            ->orderBy('name', 'asc')
                            ->get();

        $parsedUrl = parse_url(url()->current());
        // Get the path and query
        $page_url = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');
        $questions = Questions::where(function($query) use ($page_url) {
                                $query->where(function($query) {
                                    $query->where('program_type', '')
                                        ->orWhereNull('program_type'); // Handling NULL condition
                                })
                                ->orWhere(function($query) {
                                    $query->where('program_id', 0)
                                            ->where('program_type', 'youth_sports');
                                })
                                ->orWhere('page_url', $page_url);
                            })
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                                ->where('page_url', $page_url)
                                ->where('approved', '1')
                                ->orderBy('created_at', 'desc')
                                ->get();
            if( !empty($answers) ){
                foreach ($answers as $answer) {
                    $answer->answer_by = $this->badWordService->maskBadWords($answer->answer_by);
                    $answer->answer = $this->badWordService->maskBadWords($answer->answer);
                }
                $question->answers = $answers;
            }
            else{
                $question->answers = [];
            }

            $created = Carbon::createFromFormat('Y-m-d H:i:s', $question->created_at);
            $now = Carbon::now();
            $interval = $now->diff($created);

            $question->passed = $this->formatInterval($interval);
            $question->question_by = $this->badWordService->maskBadWords($question->question_by);
            $question->question = $this->badWordService->maskBadWords($question->question);
        }

        return view('youth_sports_city', compact('user', 'activities', 'state', 'city', 'questions', 'page_url'));
    }

    public function activity_create(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }

        $category = request()->route()->parameter('category');

        $states = States::all();
        
        $activity = [];
        $message = '';
        $method = $request->method();
        $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        
        if ($method == "POST") {
            $valid_item = [
                'name' => 'required|min:5',
                'address' => 'required|min:5',
                'city' => 'required|min:3',
                'state' => 'required',
                'zip' => 'required|min:5',
                'phone' => 'required|min:10',
                'email' => 'required',
            ];

            if ($response->isSuccess()) {
                // reCAPTCHA verification successful, process the form submission
            }
            else{
                $valid_item['recaptcha-token'] = 'required';
            }

            $validated = $request->validate($valid_item);
            
            $push_data = [];
            $push_data['name'] = $request->name;
            $push_data['address'] = $request->address;
            $push_data['city'] = $request->city;
            $push_data['state'] = $request->state;
            $push_data['zip'] = $request->zip;
            $push_data['phone'] = $request->phone;
            $push_data['email'] = $request->email;
            $push_data['note'] = ($request->note) ? $request->note : '';
            $push_data['details'] = ($request->details) ? $request->details : '';
            $push_data['url'] = ($request->url) ? $request->url : '';
            $push_data['kids_program_url'] = ($request->kidsProgramUrl) ? $request->kidsProgramUrl : '';
            $push_data['summer_program_url'] = ($request->summerProgramUrl) ? $request->summerProgramUrl : '';
            $push_data['video_url'] = ($request->videoUrl) ? $request->videoUrl : '';
            $push_data['claim'] = $request->claim;
            $push_data['created'] = new \DateTime();
            $push_data['updated'] = new \DateTime();
            $push_data['approved'] = 0;
            $push_data['user_id'] = $user->id;
            $push_data['ext_id'] = '';
            $push_data['category'] = strtoupper($category);
            $push_data['filename'] = $this->generateFilename($request->name, $request->city, $request->state);
            $push_data['sub_category'] = '';
            $push_data['gender'] = '';
            $push_data['type'] = '';
            $push_data['season'] = '';
            $push_data['state_association'] = '';
            $push_data['region'] = '';
            $push_data['motto'] = '';
            $push_data['contact_name'] = '';
            
            $activity = Activity::create($push_data);

            $message = '<br/>Thank you for submiting the information.<br/><br/>The listing will be verified before being set LIVE on AfterSchoolPrograms.us';
            if($user->type == 'ADMIN'){
                $activity->approved = 1;
            }
            
            $activity->save();
        }

        return view('activity_form', compact('user', 'states', 'message', 'request', 'activity'));
    }

    public function activity_edit(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login?return_url='.$request->fullUrl());
        }

        $states = States::all();

        $id = request()->route()->parameter('id');

        if (!$id) {
            return redirect('/');
        }

        $method = $request->method();
        $message = '';
        $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        $activity = Activity::where('id', $id)->first();

        if (!$activity) {
            return redirect('/');
        }

        if ($method == "POST") {
            $valid_item = [
                'name' => 'required|min:5',
                'address' => 'required|min:5',
                'city' => 'required|min:3',
                'state' => 'required',
                'zip' => 'required|min:5',
                'phone' => 'required|min:10',
                'email' => 'required',
            ];

            if ($response->isSuccess()) {
                // reCAPTCHA verification successful, process the form submission
            }
            else{
                $valid_item['recaptcha-token'] = 'required';
            }

            $validated = $request->validate($valid_item);

            $push_data = [];
            if ( !isset($user->type) || (isset($user->type) && $user->type != "ADMIN") ) {
                $push_data['activity_id'] = $id;
                $push_data['name'] = $request->name;
                $push_data['address'] = $request->address;
                $push_data['city'] = $request->city;
                $push_data['state'] = $request->state;
                $push_data['zip'] = $request->zip;
                $push_data['category'] = $activity->category;
                $push_data['phone'] = $request->phone;
                $push_data['email'] = $request->email;
                $push_data['note'] = ($request->note) ? $request->note : '';
                $push_data['details'] = ($request->details) ? $request->details : '';
                $push_data['url'] = ($request->url) ? $request->url : '';
                $push_data['kids_program_url'] = ($request->kidsProgramUrl) ? $request->kidsProgramUrl : '';
                $push_data['summer_program_url'] = ($request->summerProgramUrl) ? $request->summerProgramUrl : '';
                $push_data['video_url'] = ($request->videoUrl) ? $request->videoUrl : '';
                $push_data['claim'] = $request->claim;
                $push_data['created'] = new \DateTime();
                $push_data['updated'] = new \DateTime();
                $push_data['approved'] = 0;
                $push_data['user_id'] = $user->id;
                $push_data['ext_id'] = $activity->category;
                $push_data['filename'] = $activity->filename;
                $push_data['sub_category'] = $activity->sub_category;
                $push_data['gender'] = $activity->gender;
                $push_data['type'] = $activity->type;
                $push_data['season'] = $activity->season;
                $push_data['state_association'] = $activity->state_association;
                $push_data['region'] = $activity->region;
                $push_data['motto'] = $activity->motto;
                $push_data['contact_name'] = $activity->contact_name;

                $activity = Activitylogs::create($push_data);
                $message = 'All updated listings will be verified before being set LIVE on AfterSchoolPrograms.us';
            }
            else{
                $activity->name = $request->name;
                $activity->address = $request->address;
                $activity->city = $request->city;
                $activity->state = $request->state;
                $activity->zip = $request->zip;
                $activity->phone = $request->phone;
                $activity->email = $request->email;
                $activity->note = ($request->note) ? $request->note : '';
                $activity->details = ($request->details) ? $request->details : '';
                $activity->url = ($request->url) ? $request->url : '';
                $activity->kids_program_url = ($request->kidsProgramUrl) ? $request->kidsProgramUrl : '';
                $activity->summer_program_url = ($request->summerProgramUrl) ? $request->summerProgramUrl : '';
                $activity->video_url = ($request->videoUrl) ? $request->videoUrl : '';
                $activity->claim = $request->claim;
                $activity->updated = new \DateTime();
                $activity->user_id = $user->id;

                $activity->save();
                $message = 'The information is updated successfully';
            }
        }

        return view('activity_edit', compact('activity', 'states', 'user', 'message', 'request'));
    }

    public function upload_image(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }

        $id = $request->id;
        $message = '';
        $method = $request->method();
        $new_image = [];
        
        if (!$id) {
            return redirect('/');
        }

        $activity = Activity::where('id', $id)->first();

        if (!$activity) {
            return redirect('/');
        }

        if ($user->type != "ADMIN") {
            $images = Images::where('imageable_id', $id)
                            ->where('imageable_type', 'activity')
                            ->where('user_id', $user->id)
                            ->get();
        }
        else{
            $images = Images::where('imageable_id', $id)
                            ->where('imageable_type', 'activity')
                            ->get();
        }

        $imageCount = count($images);
          
        if ($imageCount >= 8) {
            $message = 'You cannot upload anymore pictures at this point.';
            return view('activity_image_upload', compact('user', 'activity', 'message', 'images', 'new_image', 'imageCount'));
        }

        $imagePath = public_path() . '/images/activity/' . $id;

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        if ($method == "POST") {
            $image1 = $request->file('image1');
            $image2 = $request->file('image2');

            if(!empty($image1)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('center_image_upload', compact('user', 'center', 'message', 'images', 'new_image', 'imageCount'));
                }
                else{
                    $imageName = $image1->getClientOriginalName();
                    $path = $image1->move($imagePath . '/' , $imageName);
                    
                    $new_image = Images::create([
                        'imageable_id' => $id,
                        'imageable_type' => 'activity',
                        'imagename' => $imageName,
                        'altname' => ($request->image1Alt) ? $request->image1Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    $new_image->approved = 1;
                    $images[] = $new_image;

                    $imageCount++;
                }
            }

            if(!empty($image2)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('center_image_upload', compact('user', 'center', 'message', 'images', 'new_image', 'imageCount'));
                }
                else{
                    $imageName = $image2->getClientOriginalName();
                    $path = $image2->move($imagePath . '/' , $imageName);
                    
                    $new_image = Images::create([
                        'imageable_id' => $id,
                        'imageable_type' => 'activity',
                        'imagename' => $imageName,
                        'altname' => ($request->image2Alt) ? $request->image2Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    $new_image->approved = 1;
                    $images[] = $new_image;

                    $imageCount++;
                }
            }

            if(empty($image1) && empty($image2)){
                $message = 'Please upload at least one file';
            }
            else{
                $message = 'All images will be verified before being set LIVE on AfterSchoolPrograms.us';
            }
        }

        return view('activity_image_upload', compact('user', 'activity', 'message', 'images', 'new_image', 'imageCount'));
    }

    public function delete_image(Request $request)
    {
        $imageId = $request->id;

        if (!$imageId) {
            return redirect('/');
        }

        /** @var Image $image */
        $image = Images::where('id', $imageId)->first();
        
        if (!$image) {
            return redirect('/');
        }

        $imagePath = public_path() . '/images/activity/' . $image->imageable_id;
        @unlink($imagePath . '/' . $image->imagename);

        $image->delete();

        return redirect('/activity/imageupload?id=' . $image->imageable_id);
    }

    public function geocode($street, $city, $state, $zip)
    {
        $url = "http://maps.googleapis.com/maps/api/geocode/xml?sensor=false";

        $address = $street . " " . $city . " " . $state . " " . $zip;

        $requestUrl = $url . "&address=" . urlencode($address);
        $xml = simplexml_load_file($requestUrl);
        
        if (!$xml) {
            return false;
        }

        $status = $xml->status;

        if (strcmp($status, "OK") == 0) {
            $location = $xml->result->geometry->location;

            return $location->lng . "," . $location->lat;
        } else {
            return false;
        }
    }

    public function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

		if(strlen($phoneNumber) == 7) {
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phoneNumber);
        } elseif(strlen($phoneNumber) == 10) {
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phoneNumber);
        } else {
            return $phoneNumber;
        }
	}

    public function formatURL($url)
    {
		if(preg_match( "/[http|https]:/i",$url)) {
			return "<a href=\"$url\" rel=\"nofollow\" target=\"blank\">$url</a>";			
		} else if(preg_match( "/[@|\s]/i",$url) == false && preg_match( "/\.[com|org|net|info|us|co|biz]/i",$url)) {
			return "<a href=\"http://$url\" rel=\"nofollow\" target=\"blank\">$url</a>";
		} else {
			return $url;
		}
	}

    public function getNursinghomesNearbyNursinghome($nursinghomeId, $stateCode, $county, $latitude, $longitude, $distance = 10, $limit = null)
    {
        $query = Nursinghome::select('nh_nursinghome.*')
                            ->selectRaw('((ACOS(SIN(RADIANS('.$latitude.')) * SIN(RADIANS(nh_nursinghome.latitude)) + COS(RADIANS('.$latitude.')) * COS(RADIANS(nh_nursinghome.latitude)) * COS(RADIANS(('.$longitude.' - nh_nursinghome.longitude)))) * 180 / PI()) * 60 * 1.1515) AS distance')
                            ->join('cities', 'nh_nursinghome.City', '=', 'cities.city')
                            ->where('nh_nursinghome.approved', 1)
                            ->where('cities.state', $stateCode)
                            ->where('cities.county', $county)
                            ->where('nh_nursinghome.id', '<>', $nursinghomeId)
                            ->where('nh_nursinghome.latitude', '<', round($latitude, 1) + 0.4)
                            ->where('nh_nursinghome.latitude', '>', round($latitude, 1) - 0.4)
                            ->having('distance', '<=', $distance)
                            ->having('distance', '>', 0)
                            ->orderBy('distance', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        $nursinghomes = $query->get();
        
        return $nursinghomes;
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit = 'm')
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        }

        return $miles;
    }

    public function generateFilename($activity_name, $activity_city, $activity_state)
    {
        $filename = $activity_name . ' ' . $activity_city . ' ' . $activity_state;
        $filename = preg_replace('/[^a-zA-Z0-9\']/', '_', $filename);
        $filename = strtolower(str_replace("'", '', $filename));

        return $filename;
    }

    public function formatInterval($interval) {
        if ($interval->y > 0) {
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
        } elseif ($interval->m > 0) {
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
        } elseif ($interval->d > 0) {
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '');
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '');
        } else {
            return $interval->s . ' second' . ($interval->s > 1 ? 's' : '');
        }
    }
}
