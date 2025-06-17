<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        try { 
            $slug_list = [];
            $slug_list[] = view('slugs.category_buttons')->render();
            $list = Auth::user()->categories()->orderBy('label')->get();
            foreach($list as $item) {
                $slug_list[] = view('slugs.category', compact('item'))->render();
            }
            return response()->json(['list' => $slug_list]);  
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }
    }

    ## ######## ##
    ## OLD CODE ##
    ## ######## ##

    public function create()
    {
        $record = new Category();
        return $record->getForm('create');
    }

    public function store(Request $request)
    {
        $record = new Category();
        $response = $record->saveRecord($request);
        return $response;
        }

    public function show($id)
    {
        $record = Category::find($id);
        return $record->getForm('show');
    }

    public function edit($id)
    {
        $record = Category::find($id);
        return $record->getForm('edit');
   }

    public function update(Request $request, $id)
    {
        $record = Category::find($id);
        $response = $record->saveRecord($request);
        return $response;
     }

    public function destroy($id)
    {
        $record = Category::find($id);
        $response = $record->destroyRecord();
        return $response;
     }

}
