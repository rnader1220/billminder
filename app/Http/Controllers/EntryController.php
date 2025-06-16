<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Register;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        try { 
            $slug_list = [];
            $slug_list[] = view('slugs.entry_buttons')->render();
            $list = Auth::user()->entries()->orderBy('next_due_date')->get();
            foreach($list as $item) {
                $slug_list[] = view('slugs.entry', compact('item'))->render();
            }
            return response()->json(['list' => $slug_list]);  
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }
    }

    public function create(Request $request)
    {
        try { 
            $entry = new Entry([
                'user_id' => Auth::user()->id,
                'income' => $request->income,
            ]);
            $form = $this->buildView( $entry, 'create');

            return response()->json(['form' => $form]);  
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }


    }

    public function show(string $id)
    {
        try { 
            $form = $this->buildView(Entry::find($id), 'show');
            return response()->json(['form' => $form]);  
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }
    }

    public function edit(string $id)
    {
        try { 
            $form = $this->buildView(Entry::find($id), 'edit');
           return response()->json(['form' => $form]);  
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }
    }

    private function buildView($item, $mode) 
    {
        $categories = $item->income ? 
            Auth::user()->incomeCats()->orderBy('label')->get() :
            Auth::user()->expenseCats()->orderBy('label')->get();

        $accounts = Auth::user()->accounts()->orderBy('name')->get();
        $parties = $item->income ? 
            Auth::user()->payors()->orderBy('name')->get():
            Auth::user()->payees()->orderBy('name')->get();
    
        return view('features.entry', compact('mode', 'item', 'categories', 'accounts', 'parties'))->render();
    }

   public function update(Request $request, $id)
    {
        try { 
            $record = Entry::find($id);
            $this->saveRecord($request, $record);
            return response()->json(['id' => $record->id]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }

    }

    public function store(Request $request)
    {
        try { 
            $record = new Entry();       
            $this->saveRecord($request, $record);
            return response()->json(['id' => $record->id]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }

    }

    public function destroy($id)
    {
        try { 
            Entry::destroy($id);
            return response()->json(['deleted' => true]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);                 
        }
    }

    public function saveRecord(Request $request, $entry) {
        $success = true;
        $detail = '';
        $action = (isset($this->id)?'Updated':'Stored');
        $data = $request->all();
        unset($data['_token']);
        $data['autopay'] = isset($data['autopay'])?1:0;
        $data['estimated_amount'] = isset($data['estimated_amount'])?1:0;
        $data['fixed_amount'] = isset($data['fixed_amount'])?1:0;
        $data['estimated_date'] = isset($data['estimated_date'])?1:0;
        $data['income'] = $data['income']=='true'?1:0;  ## ???
        $data['amount'] = $data['amount'] === null ? 0:$data['amount'];     

        DB::beginTransaction();

        try {

            if($data['category_id'] == '_new') {
                $data['category_id'] = $this->createCategory($data['new_category_id']);
            }

            if($data['account_id'] == '_new') {
                $data['account_id'] = $this->createAccount($data['new_account_id'], true, $data['income']);
            }

            if($data['party_id'] == '_new') {
                $data['party_id'] = $this->createAccount($data['new_party_id'], false, $data['income']);
            }

            $entry->fill($data);

            if(!isset($entry->user_id)) {
                $entry->user_id = Auth::user()->id;
            }
            $entry->save();

            DB::commit();

            $id = $entry->id;
            return compact('success', 'id');

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();

            DB::rollback();

            return compact('success', 'message');
        }
    }

    ## UNTESTED ##    
    private function createCategory($label) {
        $new_category = Category::create([
            'label' => $label,
            'user_id' => Auth::user()->id,
        ]);
        return $new_category->id;
    }

    ## UNTESTED ##    
    private function createAccount($name, $is_account, $is_income) {
        if($is_account) 
            $new_account = Account::create([
                'name' => $name,
                'user_id' => Auth::user()->id,
                'account' => $is_account,
                'payee' => ($is_account ? false : !$is_income),
                'payor' => ($is_account ? false : $is_income)
            ]);
            return $new_account->id;

    }
 
    ## ######## ##
    ## OLD CODE ##
    ## ######## ##

    public function getCycle($id) {
        $register = new Register();
        $register->entry_id = $id;
        return $register->getCycle();
    } 

    public function postCycle(Request $request, $id) {
        $register = new Register();
        $register->entry_id = $id;
        return $register->storeCycle($request);
    }
}
