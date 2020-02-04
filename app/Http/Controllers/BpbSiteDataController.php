<?php

namespace App\Http\Controllers;

use App\ttf_data_bpb;
use Illuminate\Http\Request;

class BpbSiteDataController extends Controller
{
    //
    public function index()
    {
    }

    public function get_data_bpb(Request $request)
    {
        $supp_id = $request->input('supp_id');
        $supp_site_id = $request->input('supp_site_id');
        $org_id = $request->input('org_id');

        $bpb_data = ttf_data_bpb::where('supp_id',$supp_id)
                                ->where('supp_site_id',$supp_site_id)
                                ->where('org_id',$org_id)
                                ->get();

        return response()->json(
            [
                'status' => 'success',
                'bpb_data' => $bpb_data
            ], 200);
    }
}
