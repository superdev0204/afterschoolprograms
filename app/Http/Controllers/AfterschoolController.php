<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;
use App\Models\States;
use App\Models\Cities;
use App\Models\Counties;
use App\Models\Afterschools;
use App\Models\Afterschoollogs;
use App\Models\Questions;
use App\Models\Answers;
use App\Models\Reviews;
use App\Models\Images;
use Carbon\Carbon;
use App\Services\BadWordService;

class AfterschoolController extends Controller
{
    protected $badWordService;

    public function __construct(BadWordService $badWordService)
    {
        $this->badWordService = $badWordService;
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }
        
        $states = States::all();
        $status_arr = ['Full Permit' => 'Full Permit', 'License is not Renewed' => 'License is not Renewed', 'Open' => 'Open', 'Licensed' => 'Licensed'];
        
        $afterschool = [];
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
            $push_data['location'] = $request->location;
            $push_data['capacity'] = ($request->capacity) ? $request->capacity : 0;
            $push_data['age_range'] = ($request->ageRange) ? $request->ageRange : "";
            $push_data['status'] = $request->status;
            $push_data['introduction'] = ($request->introduction) ? $request->introduction : "";
            $push_data['website'] = ($request->website) ? $request->website : "";
            $push_data['claim'] = $request->claim;
            $push_data['created'] = new \DateTime();
            $push_data['approved'] = 0;
            $push_data['filename'] = $this->generateFilename($request->name, $request->city, $request->state);
            // $push_data['user_id'] = $user->id;
            $push_data['address2'] = "";
            $push_data['county'] = "";
            $push_data['type'] = "";
            $push_data['transportation'] = "";
            $push_data['visits'] = 0;
            $push_data['state_rating'] = "";
            $push_data['subsidized'] = 0;
            $push_data['accreditation'] = "";
            $push_data['cityfile'] = "";
            $push_data['daysopen'] = "";
            $push_data['hoursopen'] = "";
            $push_data['typeofcare'] = "";
            $push_data['language'] = "";
            $push_data['additionalInfo'] = "";
            $push_data['schools_served'] = "";
            
            $afterschool = Afterschools::create($push_data);

            $message = '<br/>Thank you for submiting the information.<br/><br/>The listing will be verified before being set LIVE on AfterSchoolPrograms.us';
            if(isset($user->type)){
                $afterschool->user_id = $user->id;
                
                if($user->type == 'ADMIN'){
                    $afterschool->approved = 1;
                }
            }
            
            $afterschool->save();
        }

        return view('afterschool_form', compact('user', 'states', 'status_arr', 'message', 'request', 'afterschool'));
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        
        $id = request()->route()->parameter('id');
        $filename = request()->route()->parameter('filename');
        
        if (!$id) {
            return redirect('/');
        }

        $afterschool = Afterschools::where('id', $id)->first();
        if (!$afterschool) {
            return redirect('/');
        }

        $afterschool->phone = $this->formatPhoneNumber($afterschool->phone, $afterschool->phone_ext);
        $afterschool->website = $this->formatURL($afterschool->website);
        
        if (!$afterschool->lat || !$afterschool->lng) {
            $coordinates = $this->geocode($afterschool->address, $afterschool->city , $afterschool->state, $afterschool->zip);

            if ($coordinates) {
                $coordinatesSplit = explode(",", $coordinates,2);
                $afterschool->lat = $coordinatesSplit[1];
                $afterschool->lng = $coordinatesSplit[0];
                $afterschool->save();
            }
        }
        
        $state = States::where('state_code', $afterschool->state)->first();

        $city = Cities::where('city', $afterschool->city)
                        ->where('state', $afterschool->state)
                        ->first();

        $reviews = Reviews::where('commentable_id', $afterschool->id)
                            ->where('commentable_type', 'afterschool')
                            ->where('approved', 1)
                            ->get();

        foreach($reviews as $review){
            $review->review_by = $this->badWordService->maskBadWords($review->review_by);
            $review->comments = $this->badWordService->maskBadWords($review->comments);
        }

        $images = Images::where('imageable_id', $afterschool->id)
                        ->where('imageable_type', 'afterschool')
                        ->where('approved', 1)
                        ->get();

        $programId = $afterschool->id;
        $questions = Questions::where(function($query) use ($programId) {
                                $query->where(function($query) {
                                    $query->where('program_type', '')
                                        ->orWhereNull('program_type'); // Handling NULL condition
                                })
                                ->orWhere(function($query) {
                                    $query->where('program_id', 0)
                                            ->where('program_type', 'afterschool');
                                })
                                ->orWhere(function($query) use ($programId) {
                                    $query->where('program_id', $programId)
                                            ->where('program_type', 'afterschool');
                                });
                            })
                            ->where('approved', '1')
                            ->orderBy('created_at', 'desc')
                            ->get();
        foreach ($questions as $question) {
            $answers = Answers::where('question_id', $question->id)
                                ->where('program_id', $programId)
                                ->where('program_type', 'afterschool')
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

        return view('afterschool_show', compact('user', 'afterschool', 'state', 'city', 'images', 'reviews', 'questions'));
    }

    public function state(Request $request)
    {
        $user = Auth::user();

        $stateName = request()->route()->parameter('statename');
        
        $state = States::where('statefile', $stateName)->first();

        if (!$state) {
            return redirect('/');
        }

        $cities = Cities::where('state', $state->state_code)
                        ->where('afterschool_count', '>', '0')
                        ->orderBy('city', 'asc')
                        ->get();

        $afterschools = Afterschools::where('approved', 1)
                                    ->where('introduction', '!=', '')
                                    ->where('website', '!=', '')
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
                                            ->where('program_type', 'afterschool');
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

        return view('afterschool_state', compact('user', 'afterschools', 'state', 'cities', 'questions', 'page_url'));
    }

    public function city(Request $request)
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

        $afterschools = Afterschools::where('approved', 1)
                                    ->where('state', $state->state_code)
                                    ->where('city', $city->city)
                                    ->orderBy('name', 'asc')
                                    ->orderBy('location', 'asc')
                                    ->orderBy('address', 'asc')
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
                                            ->where('program_type', 'afterschool');
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

        return view('afterschool_city', compact('user', 'afterschools', 'state', 'city', 'questions', 'page_url'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login?return_url='.$request->fullUrl());
        }

        $states = States::all();
        $status_arr = ['Full Permit' => 'Full Permit', 'License is not Renewed' => 'License is not Renewed', 'Open' => 'Open', 'Licensed' => 'Licensed'];

        $id = request()->route()->parameter('id');

        if (!$id) {
            return redirect('/');
        }

        $method = $request->method();
        $message = '';
        $recaptcha = new ReCaptcha(env('DATA_SECRETKEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        $afterschool = Afterschools::where('id', $id)->first();

        if (!$afterschool) {
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
                $push_data['afterschool_id'] = $id;
                $push_data['name'] = $request->name;
                $push_data['address'] = $request->address;
                $push_data['city'] = $request->city;
                $push_data['state'] = $request->state;
                $push_data['zip'] = $request->zip;
                $push_data['phone'] = $request->phone;
                $push_data['email'] = $request->email;
                $push_data['location'] = ($request->location) ? $request->location : "";
                $push_data['capacity'] = ($request->capacity) ? $request->capacity : 0;
                $push_data['age_range'] = ($request->ageRange) ? $request->ageRange : "";
                $push_data['status'] = ($request->status) ? $request->status : "";
                $push_data['introduction'] = ($request->introduction) ? strip_tags($request->introduction) : "";
                $push_data['website'] = ($request->website) ? $request->website : "";
                $push_data['claim'] = $request->claim;
                $push_data['created'] = new \DateTime();
                $push_data['approved'] = 0;
                $push_data['user_id'] = $user->id;
                $push_data['address2'] = "";
                $push_data['operation_id'] = "";
                $push_data['county'] = "";
                $push_data['type'] = "";
                $push_data['transportation'] = "";
                $push_data['visits'] = 0;
                $push_data['state_rating'] = "";
                $push_data['subsidized'] = 0;
                $push_data['accreditation'] = "";
                $push_data['daysopen'] = "";
                $push_data['hoursopen'] = "";
                $push_data['typeofcare'] = "";
                $push_data['language'] = "";
                $push_data['additionalInfo'] = "";
                $push_data['pricing'] = "";
                $push_data['is_activities'] = 0;
                $push_data['is_afterschool'] = 0;
                $push_data['is_camp'] = 0;
                $push_data['gmap_heading'] = 0;
                $push_data['logo'] = "";
                $push_data['schools_served'] = "";

                $afterschool = Afterschoollogs::create($push_data);
                $message = 'All updated listings will be verified before being set LIVE on AfterSchoolPrograms.us';
            }
            else{
                $afterschool->name = $request->name;
                $afterschool->address = $request->address;
                $afterschool->city = $request->city;
                $afterschool->state = $request->state;
                $afterschool->zip = $request->zip;
                $afterschool->phone = ($request->phone) ? $request->phone : "";
                $afterschool->email = $request->email;
                $afterschool->location = ($request->location) ? $request->location : "";
                $afterschool->capacity = ($request->capacity) ? $request->capacity : 0;
                $afterschool->age_range = ($request->ageRange) ? $request->ageRange : "";
                $afterschool->status = ($request->status) ? $request->status : "";
                $afterschool->introduction = ($request->introduction) ? strip_tags($request->introduction) : "";
                $afterschool->website = ($request->website) ? $request->website : "";
                $afterschool->claim = $request->claim;
                $afterschool->user_id = $user->id;
                $afterschool->updated = new \DateTime();
                
                $afterschool->save();
                $message = 'The information is updated successfully';
            }
        }

        return view('afterschool_edit', compact('afterschool', 'states', 'status_arr', 'user', 'message', 'request'));
    }

    public function upload_image(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }

        $afterschoolId = $request->id;
        $message = '';
        $method = $request->method();
        $new_image = [];
        
        if (!$afterschoolId) {
            return redirect('/');
        }

        $afterschool = Afterschools::where('id', $afterschoolId)->first();

        if (!$afterschool) {
            return redirect('/');
        }

        if ($user->type != "ADMIN") {
            $images = Images::where('imageable_id', $afterschoolId)
                            ->where('imageable_type', 'afterschool')
                            ->where('user_id', $user->id)
                            ->get();
        }
        else{
            $images = Images::where('imageable_id', $afterschoolId)
                            ->where('imageable_type', 'afterschool')
                            ->get();
        }

        $imageCount = count($images);
          
        if ($imageCount >= 8) {
            $message = 'You cannot upload anymore pictures at this point.';
            return view('afterschool_image_upload', compact('user', 'afterschool', 'message', 'images', 'new_image', 'imageCount'));
        }

        $imagePath = public_path() . '/images/afterschool/' . $afterschoolId;

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        if ($method == "POST") {
            $image1 = $request->file('image1');
            $image2 = $request->file('image2');

            if(!empty($image1)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('afterschool_image_upload', compact('user', 'afterschool', 'message', 'images', 'new_image', 'imageCount'));
                }
                else{
                    $imageName = $image1->getClientOriginalName();
                    $path = $image1->move($imagePath . '/' , $imageName);
                    
                    $new_image = Images::create([
                        'imageable_id' => $afterschoolId,
                        'imageable_type' => 'afterschool',
                        'imagename' => $imageName,
                        'altname' => ($request->image1Alt) ? $request->image1Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    if ($user->type == "ADMIN") {
                        $new_image->approved = 1;
                        $images[] = $new_image;
                    }

                    $imageCount++;
                }
            }

            if(!empty($image2)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('afterschool_image_upload', compact('user', 'afterschool', 'message', 'images', 'new_image', 'imageCount'));
                }
                else{
                    $imageName = $image2->getClientOriginalName();
                    $path = $image2->move($imagePath . '/' , $imageName);
                    
                    $new_image = Images::create([
                        'imageable_id' => $afterschoolId,
                        'imageable_type' => 'afterschool',
                        'imagename' => $imageName,
                        'altname' => ($request->image2Alt) ? $request->image2Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    if ($user->type == "ADMIN") {
                        $new_image->approved = 1;
                        $images[] = $new_image;
                    }

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

        return view('afterschool_image_upload', compact('user', 'afterschool', 'message', 'images', 'new_image', 'imageCount'));
    }

    public function delete_image(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }
        
        $imageId = $request->id;

        if (!$imageId) {
            return redirect('/');
        }

        /** @var Image $image */
        $image = Images::where('id', $imageId)->first();
        
        if (!$image) {
            return redirect('/');
        }

        $imagePath = public_path() . '/images/afterschool/' . $image->imageable_id;
        @unlink($imagePath . '/' . $image->imagename);

        $image->delete();

        return redirect('/program/imageupload?id=' . $image->imageable_id);
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

    public function formatPhoneNumber($phoneNumber, $phoneExt)
    {
        $returnPhone = $phoneNumber;
        $strippedPhoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

        if(strlen($strippedPhoneNumber) == 7) {
            $returnPhone = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $strippedPhoneNumber);
        } elseif(strlen($strippedPhoneNumber) == 10) {
            $returnPhone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $strippedPhoneNumber);
        }

        if ($phoneExt <> "") {
            return $returnPhone .", ext " . $phoneExt;
        }

        return $returnPhone;
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

    public function getSeniorcentersNearbySeniorcenter($seniorcenterId, $stateCode, $county, $latitude, $longitude, $distance = 10, $limit = null)
    {
        $query = Seniorcenter::select('sc_seniorcenter.*')
                        ->selectRaw('((ACOS(SIN(RADIANS('.$latitude.')) * SIN(RADIANS(sc_seniorcenter.latitude)) + COS(RADIANS('.$latitude.')) * COS(RADIANS(sc_seniorcenter.latitude)) * COS(RADIANS(('.$longitude.' - sc_seniorcenter.longitude)))) * 180 / PI()) * 60 * 1.1515) AS distance')
                        ->where('sc_seniorcenter.approved', 1)
                        ->where('sc_seniorcenter.state', $stateCode)
                        ->where('sc_seniorcenter.county', $county)
                        ->where('sc_seniorcenter.id', '<>', $seniorcenterId)
                        ->where('sc_seniorcenter.latitude', '<', round($latitude, 1) + 0.4)
                        ->where('sc_seniorcenter.latitude', '>', round($latitude, 1) - 0.4)
                        ->having('distance', '<=', $distance)
                        ->orderBy('distance', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        $seniorcenters = $query->get();
        
        return $seniorcenters;
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

    public function generateFilename($afterschool_name, $afterschool_city, $afterschool_state)
    {
        $filename = $afterschool_name . ' ' . $afterschool_city . ' ' . $afterschool_state;
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
