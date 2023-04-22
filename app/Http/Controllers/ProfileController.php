<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function show($id)
    {
        $record = User::find($id);
        return $record->getForm('show');
    }

    public function edit($id)
    {
        $record = User::find($id);
        return $record->getForm('edit');
    }

    public function update(Request $request, $id)
    {
        $record = User::find($id);
        $response = $record->saveRecord($request);
        return $response;
     }

    public function destroy($id)
    {
        $record = User::find($id);
        $response = $record->destroyRecord();
        return $response;
    }
}
