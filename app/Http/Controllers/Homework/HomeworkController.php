<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as Download;

use App\Models\Homework;

class HomeworkController extends Controller {
    /**
     * Get single homework view
     * @return \Illuminate\View\View
    */
    public function single(Request $request){
    	$hw = Homework::where('uuid', $request->segment(3))->first();

    	if(!$hw)
    		abort(404);

    	// Bids for the logged in user (assuming the request is coming forma solution expert)
    	$bid = $hw->bids->where('user_id', auth()->user()->id)->first();

    	return view('member/homework/single', [
    		'title' => 'Homework Details',
    		'hw' => $hw,
    		'bid' => $bid,
    		'link' => 'hwks',
    	]);

    }

    public function se_single(Request $request){
        $hw = Homework::where('uuid', $request->segment(3))->first();

        if(!$hw)
            abort(404);

        // Bids for the logged in user (assuming the request is coming forma solution expert)
        $bid = $hw->bids->where('user_id', auth()->user()->id)->first();

        return view('member/homework/se_single', [
            'title' => 'Homework Details',
            'hw' => $hw,
            'bid' => $bid,
            'link' => 'hwks',
        ]);

    }

    /**
     * Download a homework file
     * @return \Illuminate\View\View
    */
    public function downloadFile(Request $request){
    	$path = $request->path;
    	if(!$path)
    		return redirect()->back();

    	$exploded = explode('/', $path);
    	$size = sizeof($exploded);

    	$assetPath = Storage::disk('s3')->url($exploded[$size-1]);

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . basename($assetPath));

        return readfile($assetPath);

    }
}
