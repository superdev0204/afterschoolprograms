<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Activitylog;

class ActivityLogController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }

        $id = request()->route()->parameter('id');
        if (!$id) {
            return redirect('/admin');
        }

        $activityLog = Activitylog::with('activity')->find($id);
        if (!$activityLog) {
            return redirect('/admin');
        }

        $activity = Activity::where('id', $activityLog->activity_id)->first();

        return view('admin.activitylog_show', compact('user', 'activity', 'activityLog'));
    }
    
    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $activityLog = Activitylog::where('id', $id)->first();

        if(!empty($activityLog)){
            $activity = Activity::find($activityLog->activity_id);
            $activity->name = $activityLog->name;
            $activity->address = $activityLog->address;
            $activity->city = $activityLog->city;
            $activity->state = $activityLog->state;
            $activity->zip = $activityLog->zip;
            $activity->category = $activityLog->category;
            $activity->note = $activityLog->note;
            $activity->phone = $activityLog->phone;
            $activity->url = $activityLog->url;
            $activity->email = $activityLog->email;
            $activity->details = $activityLog->details;
            $activity->kids_program_url = $activityLog->kids_program_url;
            $activity->summer_program_url = $activityLog->summer_program_url;
            $activity->video_url = $activityLog->video_url;
            $activity->sub_category = $activityLog->sub_category;
            $activity->gender = $activityLog->gender;
            $activity->type = $activityLog->type;
            $activity->season = $activityLog->season;
            $activity->state_association = $activityLog->state_association;
            $activity->region = $activityLog->region;
            $activity->motto = $activityLog->motto;
            $activity->contact_name = $activityLog->contact_name;
            $activity->user_id = $activityLog->user_id;
            $activity->claim = $activityLog->claim;
            $activity->updated = new \DateTime();
            
            if (!$activity->lat || !$activity->lng) {
                $coordinates = $this->geocode($activity->address, $activity->city, $activity->state, $activity->zip);
                if ($coordinates) {
                    $coordinatesSplit = explode(",", $coordinates,2);
                    $activity->lat = $coordinatesSplit[1];
                    $activity->lng = $coordinatesSplit[0];
                }
            }

            $activity->save();

            $activityLog->approved = 1;
            $activityLog->save();
        }

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

        $activityLog = Activitylog::where('id', $id)->first();

        $activityLog->approved = -1;
        $activityLog->save();

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

        $activityLog = Activitylog::where('id', $id)->first();

        $activityLog->delete();

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
