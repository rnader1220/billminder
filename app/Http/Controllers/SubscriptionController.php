<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    ## ######## ##
    ## OLD CODE ##
    ## ######## ##



    public function payment(Request $request) {
		$record = Subscription::firstOrNew(['user_id' => Auth::user()->id]);
        return $record->updatePayment($request);
	}

    public function subscribe(Request $request) {
		$record = Subscription::firstOrNew(['user_id' => Auth::user()->id]);
        return $record->newSubscription($request);
	}

    public function cancel(Request $request) {
		$record = Subscription::firstOrNew(['user_id' => Auth::user()->id]);
        return $record->cancelSubscription($request);
	}


}
