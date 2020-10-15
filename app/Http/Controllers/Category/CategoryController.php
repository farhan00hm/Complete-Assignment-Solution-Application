<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;

class CategoryController extends Controller {
    /**
     * Get categories page
     * @return \Illuminate\View\View
    */
    public function index(){
    	$cats = Category::paginate(10);

    	return view('member/category/categories', [
    		'title' => 'Expertise Categories',
    		'cats' => $cats,
    		'link' => 'cat'
    	]);
    }

    /**
     * Get create a category page
     * @return \Illuminate\View\View
    */
    public function new(){
    	return view('member/category/new-category', [
    		'title' => 'Expertise Categories',
    		'link' => 'cat'
    	]);
    }

    /**
     * Create a category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
    	$validator = \Validator::make($request->all(), [
            'name' =>  'required|string|unique:categories',
        ]);


        if ($validator->passes()) {
        	$cat = new Category;
			$cat->name = ucwords($request->input('name'));

			if ($cat->save()) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Category created successfully.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error creating category. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Get edit category page
     * @param \Illuminate\Http\Request
     * @return \Illuminate\View\View
    */
    public function edit(Request $request){
    	$cat = Category::where('uuid', $request->segment(3))->first();

    	return view('member/category/edit-category', [
    		'title' => 'Edit a Category',
    		'link' => 'cats',
    		'cat' => $cat
    	]);
    }

    /**
     * Update a category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request){
    	$cat = Category::where('id', $request->input('id'))->first();

    	$validator = \Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$cat->id,
        ]);


        if ($validator->passes()) {
			if ($cat->update([
				'name' => $request->input('name')
			])) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Category details updated successfully.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error updating category. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Delete a category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
		if (Category::where('uuid', $request->input('uuid'))->delete()) {
			return response()->json([
                'success' => 1,
                'message' => 'Category has been deleted successfully'
            ], 200);
		} else {
			return response()->json([
                'success' => 0,
                'error' => 'Error deleting category'
            ], 409);
		}
	}

    /**
     * Get subcategories of a category
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function getSubs(Request $request){
        $subs = SubCategory::where('category_id', $request->input('id'))->get();

        $data = "";
        if(@$subs->count() > 0){
            foreach ($subs as $sub) {
                $data .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
            }
        }

        return response()->json([
            'success' => 1,
            'subs' => $data,
        ], 200);
    }
}
