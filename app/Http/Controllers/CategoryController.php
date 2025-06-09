<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    ## ######## ##
    ## OLD CODE ##
    ## ######## ##

    public function index()
    {
        $list = Category::getList();
        return $list;
    }

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

     public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if(!isset($this->user_id)) {
                $this->user_id = Auth::user()->id;
            }
        });

        self::created(function($model){
            // ... code here
        });

        self::updating(function($model){
            // ... code here
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }
}
