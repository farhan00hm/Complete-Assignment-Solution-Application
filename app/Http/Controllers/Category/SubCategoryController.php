<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\SubCategory;
use App\Models\Category;


class SubCategoryController extends Controller {
    /**
     * Get sub categories page
     * @return \Illuminate\View\View
    */
    public function index(){
    	$subs = SubCategory::paginate(10);

    	return view('member/category/subcategories', [
    		'title' => 'Expertise Sub Categories',
    		'subs' => $subs,
    		'link' => 'cat'
    	]);
    }

    /**
     * Get create a sub category page
     * @return \Illuminate\View\View
    */
    public function new(){
    	$cats = Category::all();

    	return view('member/category/new-subcategory', [
    		'title' => 'New Expertise Categories',
    		'cats' => $cats,
    		'link' => 'cat'
    	]);
    }

    /**
     * Create a sub category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
    	$validator = \Validator::make($request->all(), [
    		'category' => 'required',
            'name' =>  'required|string',
        ]);

    	if ($validator->passes()) {
        	$sub = new SubCategory;
            $sub->name = ucwords($request->input('name'));
            $sub->category_id = $request->input('category');
           
           if ($sub->save()) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Sub category created successfully.'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error creating sub category. Refresh browser and try again'
                ], 409);
            }
        }

    	return back()->with('errors', $validator->errors());
    }

    /**
     * Get edit sub category page
     * @param \Illuminate\Http\Request
     * @return \Illuminate\View\View
    */
    public function edit(Request $request){
    	$sub = SubCategory::where('uuid', $request->segment(4))->first();
    	if (!$sub)
    		return abort(404);

    	$cats = Category::all();

    	return view('member/category/edit-subcategory', [
    		'title' => 'Edit a Sub Category',
    		'link' => 'cats',
    		'sub' => $sub,
    		'cats' => $cats
    	]);
    }

    /**
     * Update a sub category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request){
    	$sub = SubCategory::where('id', $request->input('id'))->first();
    	if (!$sub)
    		return abort(404);

    	$validator = \Validator::make($request->all(), [
    		'category' => 'required',
            'name' =>  'required|unique:sub_categories,name,'.$sub->id,
        ]);

    	if ($validator->passes()) {
    		$newFileName = $sub->poster_url;

    		if ($request->has('file')) {
    			$file = $request->file('file');
	            $name = time().$file->getClientOriginalName();
	            $filePath = $name;
	            
	            $uploaded = Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
	            $fileName = $file->getClientOriginalName();
	            $newFileName = $filePath;
	            if ($uploaded == 1) {
	                $newFileName = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $filePath);
	            } else {
	            	return back()->with('errors','Error uploading poster image to server');
	            }
    		}
            
           
           	if ($sub->update([
				'name' => ucwords($request->input('name')),
				'category_id' => $request->input('category'),
				'description' => $request->input('description'),
				'poster_url' => $newFileName,
           	])) {
		        return back()->with('success','Subcategory updated successfully');
           	} else {
        		return back()->with('errors','Error updating subcategory');
           	}
        	
        }

    	return back()->with('errors', $validator->errors());
    }

    /**
     * Delete a sub category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
		if (SubCategory::where('uuid', $request->input('uuid'))->delete()) {
			return response()->json([
                'success' => 1,
                'message' => 'Sub category has been deleted successfully'
            ], 200);
		} else {
			return response()->json([
                'success' => 0,
                'error' => 'Error deleting sub category'
            ], 409);
		}
	}
}
