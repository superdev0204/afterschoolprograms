<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Images;

class ImageController extends Controller
{
    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $imageId = $request->id;

        if (!$method == "POST" || !$imageId) {
            return redirect('/admin');
        }

        $image = Images::where('id', $imageId)->first();

        $image->approved = 1;
        $image->save();

        return redirect('/admin');
    }

    public function disapprove(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $imageId = $request->id;

        if (!$method == "POST" || !$imageId) {
            return redirect('/admin');
        }

        $image = Images::where('id', $imageId)->first();

        $image->approved = -2;
        $image->save();

        return redirect('/admin');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $imageId = $request->id;

        if (!$method == "POST" || !$imageId) {
            return redirect('/admin');
        }

        $image = Images::where('id', $imageId)->first();

        $image->delete();

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
