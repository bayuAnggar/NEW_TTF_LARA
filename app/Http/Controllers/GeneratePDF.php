<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD

use Illuminate\Support\Facades\DB;

use App\Vttf_pdf;
use App\TtfHeaders;
use App\SuppSites;
use App\Branches;
use App\TtfLines;
=======
>>>>>>> 730a4f5e0a45fdfbd4987c405170fa8f2c6f1bc8
use CPDF;

class GeneratePDF extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

<<<<<<< HEAD
    
    public function ttf(Request $request)
    {
       /* GET DATA TTF FIRST ! */
        
       $ttf_id = $request->input('ttf_id');
       $ttf_num = $request->input('ttf_num');
       $a=public_path().'\storage\img\Logo3.png';
       $ttf_id = DB::select('select @P_TTF_ID:= ?', [$request->input('ttf_id')]);
       $print_cnt=0;

       $query1 = "SELECT faktur_pajak,fp_id,tgl_fp,dpp_fp,ppn_fp FROM ttf_pdf group by faktur_pajak,fp_id,tgl_fp,dpp_fp,ppn_fp  "  ;
       //$query2="SELECT * FROM ttf_pdf where faktur_pajak ";
       $ttf1 = DB::select(DB::raw($query1));
       CPDF::addPage('P','A4');
       CPDF::SetMargins(5, 5, 5);
       CPDF::SetFont('helvetica', '', 9);
       CPDF::setFontSubsetting(false);

       $ttf3 = TtfHeaders::where('ttf_id', '=',$request->input('ttf_id'))->get()->first();
       $supp=SuppSites::where('supp_site_id', '=',$ttf3->supp_site_id)->get()->first();
       $cabang=Branches::where('branch_id','=',$supp->supp_branch_id)->get()->first();
      
       $print_cnt = $ttf3->reprint_mark;
       $returned_date =''; 
       if((date_format(date_create($ttf3->ttf_return_date),"d/m/Y") < date('d/m/Y') && ($ttf3->ttf_status == 'S')) || ($ttf3->ttf_return_date == '0000-00-00') || date_format(date_create($ttf3->ttf_return_date),"d/m/Y") > date('d/m/Y'))
        {
            if (intval($ttf3->reprint_mark) < 3) {
                $returned_date='1970-01-01';
                /*$returned_date = date_format(date_create($this->get_tgl_fisik($ttf->ORG_ID,$ttf->SUPP_ID)),"d/m/Y");
                */
                if ($returned_date != date_format(date_create($ttf3->ttf_return_date),"d/m/Y")) {
                    $print_cnt = intval($ttf3->reprint_mark)+1;
                }
                $updateDetails = [
                    
                    'ttf_return_date' =>'1970-01-01',
                    'updated_at'=>date('Y-m-d'),
                    'reprint_mark'=>$print_cnt
                ];
                TtfHeaders::where('ttf_id',$request->input('ttf_id'))
                            ->update($updateDetails);
               /* $statement="UPDATE ttf_headers SET TTF_RETURN_DATE=?,LAST_UPDATE_DATE='".date('Y-m-d')."',MEMO_NUM=? WHERE ttf_id=?";
                
                $update_ttf = $this->db->query($statement,array($this->get_tgl_fisik($ttf->ORG_ID,$ttf->SUPP_ID),$print_cnt,intval($ttfId)));*/
            } else {
                $returned_date = date_format(date_create($ttf3->ttf_return_date),"d/m/Y");
            }
        }
        else
        {
            $returned_date = date_format(date_create($ttf3->ttf_return_date),"d/m/Y");
        }
        $str_pc = '';
        $rep_rem = 0;

        if ($print_cnt > 1) {
            $rep_rem = $print_cnt - 1;
            $str_pc = 'Reprint Ke - '.$rep_rem;
        }       
       $bpb_data='
                  
                  <table  width="100%" Height="100%" border="0">
                  
                  <tr>
                        <td align="left" width="25%" rowspan="2">
                        <img src="'.$a.'" ></td>
                        <td width="50%" style="vertical-align:middle"></td>
                        <td width="25%"><font size="9"><b>Supplier</b></font></td>
                        </tr> 
                        <tr>
                            <td width="50%" style="vertical-align:middle;text-align:center"><font size="11"><b>TANDA TERIMA FAKTUR SEMENTARA</b></font></td>
                            <td width="25%"><font size="9">'.$supp->supp_site_alt_name.'-'.$supp->supp_site_code.'</font></td>
                        </tr>     
                       <tr>
                <td align="left" width="25%"></td>
                <td align="center" width=50%>
                    <b>Nomor TTF : '.$ttf_num.'/'.$cabang->branch_name.'</b>
                </td>
                <td align="left" width="25%"></td>
            </tr>
                   
                   </table>
                  
                   ';

        CPDF::writeHTML($bpb_data, true, false, true, false, '');
    

        $barcode= CPDF::write1DBarcode(trim($ttf_num), 'C128A', '', '', 0, 14, 0.6,array('position' => '','align' => 'C','stretch' => false,    'fitwidth' => '','cellfitalign' => true,'border' => false,'hpadding' => 'auto','vpadding' => 0,'fgcolor' => array(0,0,0),'bgcolor' => false,'text' => true,'font' => 'helvetica','fontsize' => 8,'stretchtext' => 4), 'N');
        $bpb_data=$barcode.' 
                <br><br><br>
                <table width="100%" border="1">
                          <tr>
                            <td width="14%" align="center" valign="middle"><b>FAKTUR PAJAK</b></td>
                            <td width="9%" align="center"><b>TGL FP</b></td>
                            <td width="11%" align="center"><b>DPP FP</b></td>
                            <td width="11%" align="center"><b>PPN FP</b></td>
                            <td width="8%" align="center"><b>NO BPB</b></td>
                            <td width="9%" align="center"><b>TGL BPB</b></td>
                            <td width="14%" align="center"><b>DPP BPB</b></td>
                            <td width="14%" align="center"><b>PPN BPB</b></td>
                            <td width="10%" align="center"><b>KET</b></td>
                          </tr>

                ';
        //dd($ttf);
        $grand_total_dpp=0;
        $grand_total_ppn=0; 
        $grand_total_all=0; 
        $subtotal_dpp=0;
        $subtotal_ppn=0;
        $count=0;   
        foreach ($ttf1 as $fp) {
            $ttf2 = Vttf_pdf::where('faktur_pajak', '=', $fp->faktur_pajak)->get();
            $count_ttflines=TtfLines::where('ttf_fp_id', '=',$fp->fp_id)->count();
            $bpb_data.='<tr style="font-size:7.6">
                            <td valign="middle" align="center" rowspan="'.$count_ttflines.'" height="12px">'.$fp->faktur_pajak.'</td>
                            <td align="center" height="12px"  rowspan="'.$count_ttflines.'">'. date("d/m/Y", strtotime($fp->tgl_fp)).'</td> 
                            <td align="right" height="12px"  rowspan="'.$count_ttflines.'">'.number_format(intval($fp->dpp_fp), 0, '.', ',').'</td> 
                            <td align="right" height="12px"   rowspan="'.$count_ttflines.'">'.number_format(intval($fp->dpp_fp), 0, '.', ',').'</td> ';

            foreach ($ttf2 as $res)
            {   

                if($count > 0)
                {
                    $bpb_data .= '
                        <tr style="font-size:7.6">
                    ';
                }
                $bpb_data.='<td align="center" height="12px">'.$res->no_bpb.'</td> 
                            <td align="center" height="12px">'. date("d/m/Y", strtotime($res->tgl_bpb)).'</td>    
                            <td align="right" height="12px">'.number_format($res->dpp_bpb,0,',','.').'</td>    
                            <td align="right" height="12px">'.number_format($res->ppn_bpb,0,',','.').'</td>
                            <td align="center" height="12px">'.$res->ket.'</td>
                            </tr>';
                $grand_total_ppn+=$res->ppn_bpb;
                $grand_total_dpp+=$res->dpp_bpb;
                $subtotal_ppn+=$res->ppn_bpb;
                $subtotal_dpp+=$res->dpp_bpb;
                $count+=1;
            }
            $bpb_data.='<tr><td colspan="6" align="center"><b>Total Faktur Pajak</b></td>
                        <td align="right" height="15px"><b>'.number_format($subtotal_dpp,0,',','.').'</b></td>
                        <td align="right" height="15px"><b>'.number_format($subtotal_ppn,0,',','.').'</b></td>
                        <td></td>
                    </tr>';
            $count=0;
        }
        
        $grand_total_all=$grand_total_dpp+$grand_total_ppn;
        $bpb_data.='<tr><td colspan="6" rowspan="2" align="center"><b>GRAND TOTAL</b></td>
                        <td align="right" height="15px"><b>'.number_format($grand_total_dpp,0,',','.').'</b></td>
                        <td align="right" height="15px"><b>'.number_format($grand_total_ppn,0,',','.').'</b></td>
                        <td></td>
                    </tr><tr>
                        <td colspan="2" height="15px" align="center"><b>'.number_format($grand_total_all,0,',','.').'</b></td>
                        <td></td>
                    </tr></table>
                    <table>
                    <tr>
                        <td style="width:100px"></td>
                        <td align="center">
                        <br><br><br>Harap Kembali pada tanggal <b></b></td>
                    </tr>
                    <tr>
                        <td style="width:100px"></td>
                        <td align="center">(Untuk Validated)
                        '.$str_pc.'</td>
                    </tr>
                    </table>
                    <br>
                    <br>
                    <br>
                    <ul>
                        <li>Di cetak pada '.date("d/m/Y H:i:s").'</li>
                    
                    <li>SYARAT DAN KETENTUAN BERLAKU</li>
                    <li>Jika ada perbedaan data antara dokumen tercetak dengan system Indogrosir , maka data yang valid ada pada system Indogrosir</li>
                    </ul>';
       // dd($bpb_data);
        CPDF::writeHTML($bpb_data, true, false, true, false, '');

        CPDF::Output('hello_world.pdf');

        
=======

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
>>>>>>> 730a4f5e0a45fdfbd4987c405170fa8f2c6f1bc8
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
