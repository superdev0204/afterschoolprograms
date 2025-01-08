<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reviews;
use App\Models\Afterschools;
use App\Models\Activity;
use App\Models\User;

class ReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if(!$user || $user->type != 'ADMIN'){
            return redirect('/user/login');
        }
        
        $reviews = Reviews::where('approved', '0')
                            ->orderByDesc('review_date')
                            ->limit(100)
                            ->get();

        foreach ($reviews as $review){
            if($review->commentable_type == 'afterschool'){
                $afterschool = Afterschools::where('id', $review->commentable_id)->first();
                $review->afterschool_id = $afterschool->id;
                $review->filename = $afterschool->filename;
            }
            else{
                $activity = Activity::where('id', $review->commentable_id)->first();
                $review->activity_id = $activity->id;
                $review->filename = $activity->filename;
                $review->category = $activity->category;
            }
            
            if($review->user_id){
                $user_info = User::where('id', $review->user_id)->first();
                $review->user_name = $user_info->first_name . ' ' . $user_info->last_name;
            }
        }
        
        return view('admin.reviewlog', compact('reviews', 'user'));
    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();
        
        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin/review');
        }

        $review = Reviews::where('id', $id)->first();
        $review->approved = 1;
        $review->save();

        return redirect('/admin/review');
    }

    public function disapprove(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin/review');
        }

        $review = Reviews::where('id', $id)->first();

        $review->approved = -2;
        $review->save();

        return redirect('/admin/review');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $method = $request->method();

        $id = $request->id;

        if (!$method == "POST" || !$id) {
            return redirect('/admin/review');
        }

        $review = Reviews::where('id', $id)->first();
        $review->delete();

        return redirect('/admin/review');
    }
}
