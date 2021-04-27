<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function getAllDonation()
    {
        $donation_list = Donation::orderBy('id', 'DESC')->get();
        return view('donation_list', compact('donation_list'));
    }
}
