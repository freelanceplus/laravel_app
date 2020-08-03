<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerLandingPageController extends Controller
{
    public function showLandingPage(){
        return view('buyer.landingPage');
    }
}
