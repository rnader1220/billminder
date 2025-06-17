<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountController extends Controller
{

    public function index(Request $request)
    {
        try { 
            $slug_list = [];
            $slug_list[] = view('slugs.account_buttons')->render();
            $list = Auth::user()->accounts()->orderBy('name')->get();
            foreach($list as $item) {
                $slug_list[] = view('slugs.account', compact('item'))->render();
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
        $record = new Account();
        return $record->getForm('create');
    }

    public function store(Request $request)
    {
        $record = new Account();
        $response = $record->saveRecord($request);
        return $response;
       }

    public function show($id)
    {
        $record = Account::find($id);
        return $record->getForm('show');
    }

    public function edit($id)
    {
        $record = Account::find($id);
        return $record->getForm('edit');
    }

    public function update(Request $request, $id)
    {
        $record = Account::find($id);
        $response = $record->saveRecord($request);
        return $response;
    }

    public function destroy($id)
    {
        $record = Account::find($id);
        $response = $record->destroyRecord();
        return $response;
    }
}
