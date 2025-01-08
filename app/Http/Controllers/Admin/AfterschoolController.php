<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;
use App\Models\Afterschools;
use App\Models\States;

class AfterschoolController extends Controller
{
    public function search(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }

        $states = States::all();
        
        if ($method == "POST") {
            $post = $request->all();
            $post = array_filter($post);
            unset($post['search']);
            unset($post['_token']);

            if (empty($post)) {
                $message = 'Please enter a search criteria!';
                return view('admin.afterschool_search', compact('user', 'states', 'request', 'message'));
            }

            $query = Afterschools::orderBy('name', 'asc');
            if($request->name){
                $values = explode(' ', $request->name);
                foreach ($values as $value) {
                    $query->where('name', 'like', '%' . $value . '%');
                }
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

            $afterschools = $query->limit(100)->get();

            return view('admin.afterschool_search', compact('user', 'states', 'request', 'afterschools'));
        }

        return view('admin.afterschool_search', compact('user', 'states', 'request'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }

        $states = States::all();
        $status_arr = ['Full Permit' => 'Full Permit', 'License is not Renewed' => 'License is not Renewed', 'Open' => 'Open', 'Licensed' => 'Licensed'];

        $id = $request->id;

        if (!$id) {
            return redirect('/');
        }

        $method = $request->method();
        $message = '';
        
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

            $validated = $request->validate($valid_item);

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

        return view('admin.afterschool_edit', compact('afterschool', 'states', 'status_arr', 'user', 'message', 'request'));
    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin');
        }

        $afterschool = Afterschools::where('id', $id)->first();

        $coordinates = $this->geocode($afterschool->address, $afterschool->city, $afterschool->state, $afterschool->zip);
        if ($coordinates) {
            $coordinatesSplit = explode(",", $coordinates,2);
            $afterschool->lat = $coordinatesSplit[1];
            $afterschool->lng = $coordinatesSplit[0];
        }

        $afterschool->approved = 1;
        $afterschool->save();

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

        $afterschool = Afterschools::where('id', $id)->first();

        $afterschool->approved = -2;
        $afterschool->save();

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

        $afterschool = Afterschools::where('id', $id)->first();

        $afterschool->delete();

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
