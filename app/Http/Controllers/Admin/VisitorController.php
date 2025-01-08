<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Visitors;

class VisitorController extends Controller
{
    public function visitor_counts(Request $request)
    {
        $user = Auth::user();
        $visitor_counts = Visitors::orderBy('date', 'desc')->paginate(100);

        if(isset($user->type) && $user->type == 'ADMIN'){
            return view('admin.visitor_counts', compact('user', 'visitor_counts'))->with('success', session('success'));
        }
        else{
            return redirect('/user/login?return_url='.request()->path());
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
