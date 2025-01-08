<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\States;
use App\Models\Cities;
use App\Models\Headstartprograms;
use App\Models\Headstartprogramlogs;
use App\Models\Images;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/user/login');
        }

        $programId = $request->id;
        $message = 'Please upload at least one file';
        $method = $request->method();
        
        if (!$programId) {
            return redirect('/');
        }

        $program = Headstartprograms::where('id', $programId)->first();

        if (!$program) {
            return redirect('/');
        }

        if ($user->type != "ADMIN") {
            $images = Images::where('imageable_id', $programId)
                            ->where('imageable_type', 'PROGRAM')
                            ->where('user_id', $user->id)
                            ->get();
        }
        else{
            $images = Images::where('imageable_id', $programId)
                            ->where('imageable_type', 'PROGRAM')
                            ->get();
        }

        $imageCount = count($images);
          
        if ($imageCount >= 8) {
            $message = 'You cannot upload anymore pictures at this point.';
            return view('image_upload', compact('user', 'program', 'message', 'images', 'imageCount'));
        }

        $imagePath = public_path() . '/images/programs/' . $programId;

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        if ($method == "POST") {
            $image1 = $request->file('image1');
            $image2 = $request->file('image2');

            if(!empty($image1)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('image_upload', compact('user', 'clinic', 'message', 'images', 'imageCount'));
                }
                else{
                    $imageName = $image1->getClientOriginalName();
                    $path = $image1->move($imagePath . '/' , $imageName);
                    
                    $image = Images::create([
                        'imageable_id' => $programId,
                        'imageable_type' => 'PROGRAM',
                        'imagename' => $imageName,
                        'altname' => ($request->image1Alt) ? $request->image1Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    $imageCount++;
                }
            }

            if(!empty($image2)){
                if ($imageCount >= 8) {
                    $message = 'You cannot upload anymore pictures at this point.';
                    return view('image_upload', compact('user', 'clinic', 'message', 'images', 'imageCount'));
                }
                else{
                    $imageName = $image2->getClientOriginalName();
                    $path = $image2->move($imagePath . '/' , $imageName);
                    
                    $image = Images::create([
                        'imageable_id' => $programId,
                        'imageable_type' => 'PROGRAM',
                        'imagename' => $imageName,
                        'altname' => ($request->image2Alt) ? $request->image2Alt : "",
                        'approved' => 0,
                        'user_id' => $user->id,
                        'created' => new \DateTime()
                    ]);

                    $imageCount++;
                }
            }

            if(empty($image1) && empty($image2)){
                $message = 'Please upload at least one file';
            }
            else{
                $message = 'All images will be verified before being set LIVE on HeadstartPrograms.org';
                return redirect('/program/imageupload?id=' . $programId);
            }
        }

        return view('image_upload', compact('user', 'program', 'message', 'images', 'imageCount'));
    }

    public function delete(Request $request)
    {
        $imageId = $request->id;

        if (!$imageId) {
            return redirect('/');
        }

        /** @var Image $image */
        $image = Images::where('id', $imageId)->first();
        
        if (!$image) {
            return redirect('/');
        }

        $imagePath = public_path() . '/images/programs/' . $image->imageable_id;
        @unlink($imagePath . '/' . $image->imagename);

        $image->delete();

        return redirect('/program/imageupload?id=' . $image->imageable_id);
    }
}
