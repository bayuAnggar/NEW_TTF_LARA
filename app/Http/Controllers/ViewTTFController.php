<?php

namespace App\Http\Controllers;

use App\inq_ttf_view;
use Illuminate\Http\Request;
use App\Http\Controllers\Input;
use Illuminate\Support\Facades\DB;
//use Auth;

class ViewTTFController extends Controller
{

    public function show(Request $request)
    {
        // $ttf = inq_ttf_view::all();
        // $ttf = inq_ttf_view::where('SUPP_ID',$supp_id)->all();

        $supp_id = DB::select('select @p_supp_id:= ?', [$request->input('supp_id')]);
        $org_id = DB::select('select @p_org_id:= ?', [$request->input('org_id')]);

        // DB::statement(DB::raw('SET @p_supp_id= :supp_id,@p_org_id= :org_id',['supp_id'=>$supp_id,'org_id'=>$org_id]));

        $query = "SELECT itv.* FROM igr_new_2.inq_ttf_views itv"  ;
        // $query = "SELECT itv.* FROM (select @p_supp_id=:suppId) p_supp_id, (select @p_org_id=:orgId) p_org_id, igr_new_2.inq_ttf_views itv";

        // $values = [$supp_id, $org_id];
        $ttf = DB::select(DB::raw($query));

        // $ttf = DB::select($query, [$supp_id, $org_id]);

        // $ttf_result = get_object_vars($ttf);

        return response()->json(
            [
                'status' => 'success',
                'ttf' => $ttf
            ], 200);
    }

    // public function show(Request $request)
    // {
    //     $supp_id = $request->get('supp_id');
    //     $ttf = inq_ttf_view::where('SUPP_ID',$supp_id)->get();

    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'ttf' => $ttf
    //         ], 200);
    // }


}
