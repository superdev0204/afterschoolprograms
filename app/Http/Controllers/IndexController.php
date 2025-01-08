<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Activity;
use App\Models\Afterschools;
use App\Models\States;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $afterschools = Afterschools::where('approved', 1)
                                    ->where('introduction', '<>', '')
                                    ->orderByDesc('updated')
                                    ->limit(5)
                                    ->get();
        
        // foreach ($afterschools as $afterschool){
        //     $afterschool->phone = $this->formatPhoneNumber($afterschool->phone);
        // }

        $states = States::where('country', 'US')->get();

        return view('index', compact('afterschools', 'states', 'user', 'request'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $types = [
            'afterschool' => 'Afterschool', 
            'martial-arts' => 'Martial Arts', 
            'youth-sports' => 'Youth Sports'
        ];
        $message = 'Please enter one of the following criteria for search.';
        return view('search', compact('user', 'types', 'message'));
    }

    public function search_results(Request $request)
    {
        $user = Auth::user();
        
        $types = [
            'afterschool' => 'Afterschool', 
            'martial-arts' => 'Martial Arts', 
            'youth-sports' => 'Youth Sports'
        ];

        $withErrors = [];
        if(!$request->location){
            $withErrors['location'] = 'The location field is required';
        }

        if($request->location && strlen($request->location) < 3){
            $withErrors['location'] = 'The location field must be at least 5 characters.';
        }

        // if(!$request->name){
        //     $withErrors['name'] = 'The name field is required';
        // }
        
        if($request->name && strlen($request->name) < 5){
            $withErrors['name'] = 'The name field must be at least 5 characters.';
        }

        // if(!$request->address){
        //     $withErrors['address'] = 'The address field is required';
        // }
        
        if($request->address && strlen($request->address) < 5){
            $withErrors['address'] = 'The address field must be at least 5 characters.';
        }

        // if(!$request->phone){
        //     $withErrors['phone'] = 'The phone field is required';
        // }
        
        if($request->phone && strlen($request->phone) < 10){
            $withErrors['phone'] = 'The phone field must be at least 10 characters.';
        }

        if(count($withErrors) > 0){
            $message = 'Please enter one of the following criteria for search.';
            return view('search', compact('user', 'types', 'message', 'request'))->withErrors($withErrors);
        }

        if ($request->type == 'afterschool') {
        
            $query = Afterschools::where('approved', 1)
                                ->limit(100);

            if (preg_match('/\d+/', $request->location, $matches)) {
                $query->where('zip', $matches[0]);
            } else {
                @list($city, $stateCode) = explode(',', $request->location);

                if ($city) {
                    $query->where('city', trim($city));
                }

                if ($stateCode) {
                    $query->where('state', trim($stateCode));
                }
            }

            if ($request->name) {
                $query->where('name', $request->name);
            }

            if ($request->address) {
                $query->where('address', $request->address);
            }

            if ($request->phone) {
                $query->where('phone', $request->phone);
            }

            $afterschools = $query->get();

            if (!count($afterschools)) {
                $message = 'There is no result for your selected criteria.  Please try again with different criteria.';
            }
            else{
                $message = 'There are ' . count($afterschools) . ' afterschools found.';
            }
        
            return view('search_afterschool_results', compact('afterschools', 'user', 'message', 'request'));
        }
        else{
            $query = Activity::where('approved', 1)
                            ->where('category', strtoupper($request->type))
                            ->limit(100);

            if (preg_match('/\d+/', $request->location, $matches)) {
                $query->where('zip', $matches[0]);
            } else {
                @list($city, $stateCode) = explode(',', $request->location);

                if ($city) {
                    $query->where('city', trim($city));
                }

                if ($stateCode) {
                    $query->where('state', trim($stateCode));
                }
            }

            if ($request->name) {
                $query->where('name', $request->name);
            }

            if ($request->address) {
                $query->where('address', $request->address);
            }

            if ($request->phone) {
                $query->where('phone', $request->phone);
            }

            $activities = $query->get();

            if (!count($activities)) {
                $message = 'There is no result for your selected criteria.  Please try again with different criteria.';
            }
            else{
                if ($request->type == 'martial-arts') {
                    $message = 'There are ' . count($activities) . ' martial art schools found.';
                }

                if ($request->type == 'youth-sports') {
                    $message = 'There are ' . count($activities) . ' youth sport clubs found.';
                }
            }

            return view('search_activity_results', compact('activities', 'user', 'message', 'request'));
        }
    }

    public function faqs()
    {
        return view('faqs');
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
}
