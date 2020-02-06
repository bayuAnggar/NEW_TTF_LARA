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
<<<<<<< HEAD

        $bpb_data = ttf_data_bpb::where('supp_id',$supp_id)
                                ->where('supp_site_id',$supp_site_id)
                                ->where('org_id',$org_id)
                                ->get();
=======
        $not_include_bpb = $request->input('not_include_bpb');

        if(count($not_include_bpb) > 0)
        {
            $bpb_data = ttf_data_bpb::where('supp_id',$supp_id)
                                ->where('supp_site_id',$supp_site_id)
                                ->where('org_id',$org_id)
                                ->whereNotIn('bpb_id',$not_include_bpb)
                                ->get();
        }
        else
        {
            $bpb_data = ttf_data_bpb::where('supp_id',$supp_id)
                                ->where('supp_site_id',$supp_site_id)
                                ->where('org_id',$org_id)
                                ->get();
        }

>>>>>>> 730a4f5e0a45fdfbd4987c405170fa8f2c6f1bc8

        return response()->json(
            [
                'status' => 'success',
                'bpb_data' => $bpb_data
            ], 200);
    }
}
