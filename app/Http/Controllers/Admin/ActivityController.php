<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;
use App\Models\Activity;
use App\Models\States;

class ActivityController extends Controller
{
    public function search(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }

        $states = States::all();

        $types = [
            'martial-arts' => 'Martial Arts', 
            'youth-sports' => 'Youth Sports'
        ];
        
        if ($method == "POST") {
            $post = $request->all();
            $post = array_filter($post);
            unset($post['search']);
            unset($post['_token']);

            if (empty($post)) {
                $message = 'Please enter a search criteria!';
                return view('admin.activity_search', compact('user', 'states', 'request', 'message', 'types'));
            }

            $query = Activity::orderBy('name', 'asc');
            if($request->name){
                $values = explode(' ', $request->name);
                foreach ($values as $value) {
                    $query->where('name', 'like', '%' . $value . '%');
                }
            }

            if($request->type){
                $query->where('category', strtoupper($request->type));
            }

            if($request->phone){
                $strippedPhoneNumber = preg_replace("/[^0-9]/", "", $request->phone);
                if (strlen($strippedPhoneNumber) == 10) {
                    $query->where('phone', 'like', '%' . substr($strippedPhoneNumber, 0, 3) . '%')
                        ->where('phone', 'like', '%' . substr($strippedPhoneNumber, 3, 3) . '-' . substr($strippedPhoneNumber, -4));
                } else {
                    $query->where('phone', 'like', '%' . $request->phone . '%');
                }
            }

            if($request->address){
                $query->where('address', 'like', '%' . $request->address . '%');
            }

            if($request->zip){
                $query->where('zip', $request->zip);
            }

            if($request->city){
                $query->where('city', $request->city);
            }

            if($request->state){
                $query->where('state', $request->state);
            }

            if($request->email){
                $query->where('email', $request->email);
            }

            if($request->id){
                $query->where('id', $request->id);
            }

            $activities = $query->limit(100)->get();

            return view('admin.activity_search', compact('user', 'states', 'request', 'activities', 'types'));
        }

        return view('admin.activity_search', compact('user', 'states', 'request', 'types'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }

        $states = States::all();

        $id = $request->id;

        if (!$id) {
            return redirect('/');
        }

        $method = $request->method();
        $message = '';
        
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

            $validated = $request->validate($valid_item);

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

        return view('admin.activity_edit', compact('activity', 'states', 'user', 'message', 'request'));
    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $activity = Activity::where('id', $id)->first();

        $coordinates = $this->geocode($activity->address, $activity->city, $activity->state, $activity->zip);
        if ($coordinates) {
            $coordinatesSplit = explode(",", $coordinates,2);
            $activity->lat = $coordinatesSplit[1];
            $activity->lng = $coordinatesSplit[0];
        }

        $activity->approved = 1;
        $activity->save();

        return redirect('/admin');
    }

    public function disapprove(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $activity = Activity::where('id', $id)->first();

        $activity->approved = -2;
        $activity->save();

        return redirect('/admin');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $activity = Activity::where('id', $id)->first();

        $activity->delete();

        return redirect('/admin');
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
}
