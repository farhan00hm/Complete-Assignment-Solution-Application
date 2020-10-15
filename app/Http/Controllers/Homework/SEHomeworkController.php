<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Jobs\SEHomeworkSubmitted;

use App\Models\Homework;
use App\Models\Subject;
use App\Models\HomeworkSolution;
use App\Models\HomeworkSolutionFile;

class SEHomeworkController extends Controller {
    /**
     * Get all open homeworks - receiving bids
     * @return \Illuminate\View\View
    */
    public function open(Request $request){
        $subsArray = array();
        $subjects = Subject::where('expert_id', auth()->user()->expert->id)->get();
        foreach ($subjects as $subject) {
            array_push($subsArray, $subject->sub_category_id);
        }

        $hws = Homework::where('status', 1)->whereIn('sub_category_id', $subsArray)->orderBy('id', 'DESC')->paginate(10);

    	return view('member/homework/fl/open', [
    		'title' => 'Open Homeworks',
    		'hws' => $hws,
    		'link' => 'hwks',
    	]);

    }

    /**
     * Get all ongoing homeworks - working on them
     * @return \Illuminate\View\View
    */
    public function ongoing(Request $request){
        $hws = Homework::whereIn('status', [3, 5])->where('awarded_to', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/homework/fl/ongoing', [
            'title' => 'Ongoing Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

    }


   /**
     * Get ongoing homeworks - already hired
     * @return \Illuminate\View\View
    */
    public function delete(Request $request){
        if (Homework::where('uuid', $request->input('uuid'))->delete()) {

            return response()->json([
                'success' => 1,
                'message' => 'Homework has been deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error deleting homework'
            ], 409);
        }
    }

    /**
     * Get submit homework page
     * @return \Illuminate\View\View
    */
    public function submitPage(Request $request){
        $hw = Homework::whereIn('status', [3, 5])->where('awarded_to', auth()->user()->id)->where('uuid', $request->segment(3))->first();

        return view('member/homework/fl/submit', [
            'title' => 'Submit Homework',
            'hw' => $hw,
            'link' => 'hwks',
        ]);

    }

    /**
     * Submit homework solution
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function submit(Request $request) {
        $validator = \Validator::make($request->all(), [
            'notes' => 'required|string',
            'files.*' => 'nullable|max:5120'
        ]);
        if ($validator->passes()) {
 // @dd($request->all());
            DB::beginTransaction();
            // Create a homework solution
            try {
                $hws = new HomeworkSolution;
                $hws->homework_id = $request->input('id');
                $hws->notes = $request->input('notes');
                $hws->refund = $request->refund; 
                $hws->acceptness = $request->acceptness; 
                $hws->save();

            } catch (\Exception $e) {
                \Log::error($e);
                return back()->with('errors', $e->getMessage)->withInput($request->input());
            }

            // Updated Homeworks table: status - 6 (solution submitted)
            try {
                Homework::where('id', $request->input('id'))->update([
                    'status' => 6
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return back()->with('errors', $e->getMessage)->withInput($request->input());
            }

            if($request->hasfile('files')) {
                foreach($request->file('files') as $file) {
                    try {
                        $name = $file->getClientOriginalName();
                        $timeName = time().$file->getClientOriginalName();

                        $uploaded = Storage::disk('s3')->put($timeName, file_get_contents($file), 'public');
                    } catch (\Exception $e) {
                        \Log::error($e);
                        return back()->with('errors', $e->getMessage)->withInput($request->input());
                    }

                    if ($uploaded == 1) {
                        $upload_path = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $timeName);

                        try {
                            $hwsf = new HomeworkSolutionFile;
                            $hwsf->homework_solution_id = $hws->id;
                            $hwsf->name = $timeName;
                            $hwsf->original_file_name = $name;
                            $hwsf->upload_path = $upload_path;
                            $hwsf->save();

                        } catch (\Exception $e) {
                            \Log::error($e);
                            return back()->with('errors', $e->getMessage)->withInput($request->input());
                        }
                    }
                }
            }

            DB::commit();

            // Queue an email to student (homework owner allerting them of submitted homework)
            $hw = Homework::where('id', $request->input('id'))->first();
            SEHomeworkSubmitted::dispatch($hw->postedBy->email, $hw->uuid);

            return redirect('/freelancer/homeworks/completed')->with('success', 'Homework solution has been submitted.');
        }

        return back()->with('errors', $validator->errors()->all())->withInput($request->input());
    }

    /**
     * Get completed homeworks
     * @return \Illuminate\View\View
    */
    public function completed(Request $request){
        $hws = Homework::whereIn('status', [6, 8])->where('awarded_to', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/homework/fl/completed', [
            'title' => 'Completed Homeworks',
            'hws' => $hws,
            'link' => 'hwks',
        ]);

    }
}
