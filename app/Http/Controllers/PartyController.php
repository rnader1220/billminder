<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

class PartyController extends Controller
{

    public function index()
    {
        $list = Party::getList();
        return $list;
    }

    public function create()
    {
        $record = new Party();
        return $record->getForm('create');
    }

    public function store(Request $request)
    {
        $record = new Party();
        $response = $record->saveRecord($request);
        return $response;
    }

    public function show($id)
    {
        $record = Party::find($id);
        return $record->getForm('show');
    }

    public function edit($id)
    {
        $record = Party::find($id);
        return $record->getForm('edit');
    }

    public function update(Request $request, $id)
    {
        $record = Party::find($id);
        $response = $record->saveRecord($request);
        return $response;
     }

    public function destroy($id)
    {
        $record = Party::find($id);
        $response = $record->destroyRecord();
        return $response;
     }
}
