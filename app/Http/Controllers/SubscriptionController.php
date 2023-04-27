<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Package;

class SubscriptionController extends Controller
{
    //



    /* FROM GRANITE:: PAGE HELPER RENDERS TEXT JOIN HELPER HAS PROCESS:  JOIN HELPER = Models/Subscription.PHP

 	public function subscribe(Request $request) {
		return json_encode(JoinHelper::subscribe($request));
	}
    */


	// checkout -> register -> payment -> complete

    // instead of returning view, return success code; view will be rendered on front end
    // no need to set up carts, etc, as there is only one product/price, and it is either on or off.



/* 	public function checkout() {
		return view('website.checkout.register', [
			'order' => JoinHelper::order(),
			'page' => PageHelper::displayPage('reg_pre'),
			'pre_form' => PageHelper::displayPage('reg_pre'),
			'post_form' => PageHelper::displayPage('reg_post'),
			'cart' => JoinHelper::checkout(),
			'cart_count' => 0, //JoinHelper::count()
		]);
	} */

/* 	public function register(Request $request) {
		return view('website.checkout.payment', [
			'order' => JoinHelper::order(),
			'page' => PageHelper::displayPage('pay_pre'),
			'pre_form' => PageHelper::displayPage('pay_pre'),
			'post_form' => PageHelper::displayPage('pay_post'),
			'cart' => JoinHelper::register($request),
			'cart_count' => 0, //JoinHelper::count()
		]);
	} */

/* 	public function payment(Request $request) {
		JoinHelper::payment($request);
		return view('website.checkout.complete', [
			'page' => PageHelper::displayPage('cart_complete'),
			'cart_count' => 0, //JoinHelper::count()
		]);
	} */

	/* maybe maybe ?? or just go straight to checkout */
/*     public function showcart()
    {
		// get the page query for this page
		//$cart1 = PageHelper::displayPage('cart1');
		//$cart2 = PageHelper::displayPage('cart2');
		//$cart3 = PageHelper::displayPage('cart3');

		return view('website.cart', JoinHelper::table());
    } */

    /*
	public function carttable() {
		return view('website.cartitems', JoinHelper::table());
	}
    */

}
