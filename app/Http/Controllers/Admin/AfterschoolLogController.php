<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Afterschools;
use App\Models\Afterschoollogs;

class AfterschoolLogController extends Controller
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

        $afterschoolLog = Afterschoollogs::where('id', $id)->first();
        if (!$afterschoolLog) {
            return redirect('/admin');
        }

        $afterschool = Afterschools::where('id', $afterschoolLog->afterschool_id)->first();

        return view('admin.afterschoollog_show', compact('user', 'afterschool', 'afterschoolLog'));
    }
    
    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $afterschoolLog = Afterschoollogs::where('id', $id)->first();

        if(!empty($afterschoolLog)){
            $afterschool = Afterschools::find($afterschoolLog->afterschool_id);
            $afterschool->name = $afterschoolLog->name;
            $afterschool->location = $afterschoolLog->location;
            $afterschool->address = $afterschoolLog->address;
            $afterschool->address2 = $afterschoolLog->address2;
            $afterschool->city = $afterschoolLog->city;
            $afterschool->state = $afterschoolLog->state;
            $afterschool->zip = $afterschoolLog->zip;
            $afterschool->phone = $afterschoolLog->phone;
            $afterschool->phone_ext = $afterschoolLog->phone_ext;
            $afterschool->county = $afterschoolLog->county;
            $afterschool->email = $afterschoolLog->email;
            $afterschool->capacity = $afterschoolLog->capacity;
            $afterschool->status = $afterschoolLog->status;
            $afterschool->type = $afterschoolLog->type;
            $afterschool->contact_firstname = $afterschoolLog->contact_firstname;
            $afterschool->contact_lastname = $afterschoolLog->contact_lastname;
            $afterschool->age_range = $afterschoolLog->age_range;
            $afterschool->transportation = $afterschoolLog->transportation;
            $afterschool->state_rating = $afterschoolLog->state_rating;
            $afterschool->website = $afterschoolLog->website;
            $afterschool->subsidized = $afterschoolLog->subsidized;
            $afterschool->accreditation = $afterschoolLog->accreditation;
            $afterschool->daysopen = $afterschoolLog->daysopen;
            $afterschool->hoursopen = $afterschoolLog->hoursopen;
            $afterschool->typeofcare = $afterschoolLog->typeofcare;
            $afterschool->language = $afterschoolLog->language;
            $afterschool->introduction = $afterschoolLog->introduction;
            $afterschool->additionalInfo = $afterschoolLog->additionalInfo;
            $afterschool->pricing = $afterschoolLog->pricing;
            $afterschool->schools_served = $afterschoolLog->schools_served;
            $afterschool->claim = $afterschoolLog->claim;
            $afterschool->updated = new \DateTime();
            $afterschool->user_id = $afterschoolLog->user_id;
            
            if (!$afterschool->lat || !$afterschool->lng) {
                $coordinates = $this->geocode($afterschool->address, $afterschool->city, $afterschool->state, $afterschool->zip);
                if ($coordinates) {
                    $coordinatesSplit = explode(",", $coordinates,2);
                    $afterschool->lat = $coordinatesSplit[1];
                    $afterschool->lng = $coordinatesSplit[0];
                }
            }

            // $program->filename = $this->generateFilename($program->name, $program->city, $program->state);

            $afterschool->save();

            $afterschoolLog->approved = 1;
            $afterschoolLog->save();
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

        $afterschoolLog = Afterschoollogs::where('id', $id)->first();

        $afterschoolLog->approved = -1;
        $afterschoolLog->save();

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

        $afterschoolLog = Afterschoollogs::where('id', $id)->first();

        $afterschoolLog->delete();

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

    public function generateFilename($program_name, $program_city, $program_state)
    {
        $name = str_replace(["  "," ","-","(",")","/","@","+","&"],"_",$program_name);
        $name = str_replace([":",".","'",",","#","\""],"",$name);

        $city = str_replace(["  "," ","-","(",")","/","@","+","&"],"_",$program_city);
        $city = str_replace([":",".","'",",","#","\""],"",$city);

        $filename = strtolower($name . "_" . $city . "_" . $program_state);
        $filename = str_replace(["'","&"],"",$filename);
        $filename = str_replace(["___","__","-","(",")","/","@","+"],"_",$filename);
        $filename = substr($filename, 0, 100);

        return $filename;
    }
}
