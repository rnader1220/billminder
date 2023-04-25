<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $record = User::find(Auth::user()->id);
        return $record->getForm('show');
    }

    public function edit()
    {
        $record = User::find(Auth::user()->id);
        return $record->getForm('edit');
    }

    public function update(Request $request)
    {
        $record = User::find(Auth::user()->id);
        $response = $record->saveRecord($request);
        return $response;
    }

    /*
    public function destroy($id)
    {
        $record = User::find($id);
        $response = $record->destroyRecord();
        return $response;
    } */

    public function subscriber()
    {
        $record = User::find(Auth::user()->id);

        return ($record->toArray());
    }


}
