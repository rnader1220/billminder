<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Exports\Report as Export;

class ReportController extends Controller
{
    /* scheduling reports is later.  right now, its just immedate reports. */

     public function index()
     {
         $list = Report::getList();
         return $list;
     }


    public function create()
    {
        $record = new Report();
        return $record->localGetForm('create');
    }

    public function store(Request $request)
    {
        $record = new Report();
        $response = $record->localSaveRecord($request);
        return $response;
       }

       public function generate(Request $request)
       {
         (new Export($request))->store('/reports/report.xlsx');
       }

    public function show($id)
    {
        $record = Report::find($id);
        return $record->localGetForm('show');
    }

    public function edit($id)
    {
        $record = Report::find($id);
        return $record->localGetForm('edit');
    }

    public function update(Request $request, $id)
    {
        $record = Report::find($id);
        $response = $record->saveRecord($request);
        return $response;
    }

    public function destroy($id)
    {
        $record = Report::find($id);
        $response = $record->destroyRecord();
        return $response;
    }

}
