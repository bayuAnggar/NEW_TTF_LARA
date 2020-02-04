<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CPDF;

class GeneratePDF extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function ttf(Request $request)
    {
       /* GET DATA TTF FIRST ! */
       $ttf_id = $request->input('ttf_id');
       $ttf_num = $request->input('ttf_num');

       $bpb_data='
       <table width="100%" Height="100%" border="1">
                <tr>
                    <td colspan="2" align="CENTER" style="vertical-align:bottom" rowspan="3">
                        <br>
                        LOGO
                    </td>
                    <td colspan="5" align="CENTER" rowspan="3">JUDUL</td>
                    <td colspan="2" align="CENTER" rowspan="3">SUPPLIER</td>
                </tr>
               <tr>
                    <td colspan="9" align="CENTER"></td>
               </tr>
               <tr>
               <td colspan="9" align="CENTER"></td>
          </tr>
                <tr>
                    <td colspan="9" align="CENTER" rowspan="2"> BARCODE </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>
       ';

       

        // $data = [
        //         //HEADER
        //         'TTF_NUM' => '12345',
        //         'SUPP_NAME' => 'SUPPNAME-SUPP_SITE_CODE',
        //         'BRANCH_NAME' => 'CABANG',
        //         'TANGGAL KEMBALI' => '',
        //         'barcode' =>  CPDF::serializeTCPDFtagParameters(array('12345','C128A','', '',0, 14, 0.6,array('position' => '','align' => 'C','stretch' => false,    'fitwidth' => '','cellfitalign' => true,'border' => false,'hpadding' => 'auto','vpadding' => 0,'fgcolor' => array(0,0,0),'bgcolor' => false,'text' => true,'font' => 'helvetica','fontsize' => 8,'stretchtext' => 4), 'N')),
        //         'REPRINT_MARK' => 'REPRINT KE-1',
        //         'BPB_TTF' => $bpb_data
        //         ];

        // $pdf = PDF::loadView('myPDF', $data);
        // // return CPDF::download('laporan-pdf.pdf');

        // CPDF::setPaper('a4' , 'portrait');
        // return CPDF::stream();

        // $view = \View::make('PrintTTFIGR',$data);
        // $html = $view->render();
        CPDF::addPage();
        CPDF::writeHTML($bpb_data, true, false, true, false, '');
        CPDF::Output('hello_world.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
