<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Afterschools;
use App\Models\Afterschoollogs;
use App\Models\Activity;
use App\Models\Activitylog;
use App\Models\Reviews;
use App\Models\Images;
use App\Models\Visitors;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(isset($user->type) && $user->type == 'ADMIN'){
            $afterschools = Afterschools::where('approved', 0)
                                        ->orderBy('name')
                                        ->get();
            
            $afterschoolLogs = Afterschoollogs::where('approved', 0)
                                                ->where('afterschool_id', '<>', 0)
                                                ->orderBy('name')
                                                ->get();

            $activities = Activity::where('approved', 0)
                                ->orderBy('name')
                                ->get();

            $activityLogs = Activitylog::where('approved', 0)
                                        ->orderBy('name')
                                        ->get();
            
            $activityLogs = $activityLogs->filter(function ($log) {
                return !is_null(optional($log->activity)->id);
            });

            $images = Images::where('approved', 0)
                            ->orderBy('created')
                            ->get();

            foreach ($images as $image){
                if ($image->imageable_type == 'activity') {
                    $activity = Activity::where('id', $image->imageable_id)->first();
                    $image->activity_id = ($activity) ? $activity->id : 0;
                    $image->activity_filename = ($activity) ? $activity->filename : "";
                    $image->activity_category = ($activity) ? $activity->category : "";
                }
                else{
                    $afterschool = Afterschools::where('id', $image->imageable_id)->first();
                    $image->afterschool_id = ($afterschool) ? $afterschool->id : 0;
                    $image->afterschool_filename = ($afterschool) ? $afterschool->filename : "";
                }
            }

            return view('admin.index', compact('afterschools', 'afterschoolLogs', 'activities', 'activityLogs', 'images', 'user'));
        }
        else{
            return redirect('/user/login');
        }
    }

    public function visitor_counts(Request $request)
    {
        $user = Auth::user();
        $visitor_counts = Visitors::all();

        if(isset($user->type) && $user->type == 'ADMIN'){
            return view('admin.visitor_counts', compact('user', 'visitor_counts'))->with('success', session('success'));
        }
        else{
            return redirect('/login?return_url='.request()->path());
        }
    }

    public function delete_visitor(Request $request)
    {
        $user = Auth::user();
        
        if(isset($user->type) && $user->type == 'ADMIN'){
            if(isset($request->vID) && !empty($request->vID)){
                $visitor_count = Visitors::find($request->vID);
                $visitor_count->delete();
            }
            return redirect('/admin/visitor_counts')->with('success', 'The visitor count deleted successfully');
        }
        else{
            return redirect('/')->with('error', 'Invalid credentials.');
        }
        
    }
}
