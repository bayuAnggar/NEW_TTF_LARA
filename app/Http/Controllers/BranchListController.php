<?php

namespace App\Http\Controllers;

use App\branch_list_bpb;
use Illuminate\Http\Request;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\DB;
//use Auth;

class BranchListController extends Controller
{

    public function show(Request $request)
    {
        $supp_id = DB::select('select @p_supp_id:= ?', [$request->input('supp_id')]);
        $org_id = DB::select('select @p_org_id:= ?', [$request->input('org_id')]);

        // $query = "SELECT blb.* FROM igr_new_2.branch_list_bpb blb"  ;
        // $branch_list = DB::select(DB::raw($query));

        $branch_list = branch_list_bpb::select('SUPP_SITE_ID','SUPP_SITE_CODE','SUPP_SITE_NAME','TOTAL_BPB')->get();

        return response()->json(
            [
                'status' => 'success',
                'branchlist' => $branch_list
            ], 200);
    }

    public function addr_detail_supp(Request $request)
    {
        $supp_id = DB::select('select @p_supp_id:= ?', [$request->input('supp_id')]);
        $org_id = DB::select('select @p_org_id:= ?', [$request->input('org_id')]);

        $supp_site_id = $request->input('site_id');

        $site_detail = branch_list_bpb::where('SUPP_SITE_ID',$supp_site_id)->get();

        return response()->json(
            [
                'status' => 'success',
                'addr_detail' => $site_detail
            ], 200);
    }


}
