<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;

class EntryController extends Controller
{
    public function index()
    {
        $list = Entry::getList();
        return $list;
    }

    public function create()
    {
        $record = new Entry();
        return $record->getForm('create');
    }

    public function store(Request $request)
    {
        $record = new Entry();
        $response = $record->saveRecord($request);
        return $response;
    }

    public function show($id)
    {
        $record = Entry::find($id);
        return $record->getForm('show');
    }

    public function edit($id)
    {
        $record = Entry::find($id);
        return $record->getForm('edit');
    }

    public function update(Request $request, $id)
    {
        $record = Entry::find($id);
        $response = $record->saveRecord($request);
        return $response;
    }

    public function destroy($id)
    {
        $record = Entry::find($id);
        $response = $record->destroyRecord();
        return $response;
    }

    public function cycle($id)
    {
        $record = Entry::find($id);
        $response = $record->cycleRecord();
        return $response;
    }

}
