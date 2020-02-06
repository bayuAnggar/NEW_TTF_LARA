<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInqTtfView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	  {
	    //
	    DB::statement("
	      CREATE VIEW inq_ttf_view AS
	      (
	        SELECT
				`asd`.`ttf_id` AS `TTF_ID`,
				`asd`.`supp_id` AS `SUPP_ID`,
				`asd`.`supp_site_id` AS `SUPP_SITE_ID`,
				`asd`.`ttf_num` AS `TTF_NUM`,
				CASE
					WHEN `asd`.`TTF_STATUS` = '' THEN 'DRAFTED'
					WHEN `asd`.`TTF_STATUS` = 'S' THEN 'SUBMITED'
					WHEN `asd`.`TTF_STATUS` = 'K' THEN 'SUBMITED'
					WHEN `asd`.`TTF_STATUS` = 'V' THEN 'VALIDATED'
					WHEN `asd`.`TTF_STATUS` = 'R' THEN 'REJECTED'
				END AS `TTF_STATUS`,
				CASE
					WHEN `asd`.`TTF_STATUS` = '' THEN 1
					WHEN `asd`.`TTF_STATUS` = 'S' THEN 2
					WHEN `asd`.`TTF_STATUS` = 'K' THEN 3
					WHEN `asd`.`TTF_STATUS` = 'V' THEN 4
					WHEN `asd`.`TTF_STATUS` = 'R' THEN 0
				END AS `TTF_STAT_NUM`,
				`asd`.`org_id` AS `ORG_ID`,
				UCASE(DATE_FORMAT(`asd`.`ttf_date`, '%d %b %Y')) AS `TTF_DATE`,
				UCASE(DATE_FORMAT(`asd`.`ttf_return_date`, '%d %b %Y')) AS `TTF_RETURN_DATE`,
				UCASE(DATE_FORMAT(`asd`.`ttf_giro_date`, '%d %b %Y')) AS `TTF_GIRO_DATE`,
				COUNT(`asd`.`fp_number`) AS `COUNT_FP`,
				FORMAT(SUM(`asd`.`fp_dpp_amt`), 0) AS `TOTAL_FP_DPP`,
				FORMAT(SUM(`asd`.`fp_tax_amt`), 0) AS `TOTAL_FP_TAX`,
				COUNT(`asd`.`bpb_number`) AS `COUNT_BPB`,
				FORMAT(SUM(`asd`.`bpb_dpp`), 0) AS `TOTAL_BPB_DPP`,
				FORMAT(SUM(`asd`.`bpb_tax`), 0) AS `TOTAL_BPB_TAX`,
				FORMAT(SUM(`asd`.`fp_dpp_amt`) - SUM(`asd`.`bpb_dpp`),
					0) AS `SELISIH_DPP`,
				FORMAT(SUM(`asd`.`fp_tax_amt`) - SUM(`asd`.`bpb_tax`),
					0) AS `SELISIH_TAX`
			FROM
				(SELECT
					`tth`.`ttf_id` AS `ttf_id`,
						`tth`.`supp_id` AS `supp_id`,
						`tth`.`supp_site_id` AS `supp_site_id`,
						`tth`.`ttf_num` AS `ttf_num`,
						`tth`.`ttf_status` AS `TTF_STATUS`,
						`tth`.`org_id` AS `org_id`,
						`tth`.`ttf_date` AS `ttf_date`,
						`tth`.`ttf_return_date` AS `ttf_return_date`,
						`tth`.`ttf_giro_date` AS `ttf_giro_date`,
						`tfp`.`fp_number` AS `fp_number`,
						`tfp`.`fp_dpp_amt` AS `fp_dpp_amt`,
						`tfp`.`fp_tax_amt` AS `fp_tax_amt`,
						`tdb`.`bpb_number` AS `bpb_number`,
						`tdb`.`bpb_dpp` AS `bpb_dpp`,
						`tdb`.`bpb_tax` AS `bpb_tax`
				FROM
					(((`igr_new_2`.`ttf_headers` `tth`
				JOIN `igr_new_2`.`ttf_lines` `ttl`)
				JOIN `igr_new_2`.`ttf_fp_lines` `tfp`)
				JOIN `igr_new_2`.`ttf_data_bpb` `tdb`)
				WHERE
					`tth`.`ttf_id` = `ttl`.`ttf_id`
						AND `ttl`.`ttf_fp_id` = `tfp`.`ttf_fp_id`
						AND `ttl`.`ttf_bpb_id` = `tdb`.`bpb_id`
						AND `tth`.`supp_id` = P_SUPP_ID()
						AND `tth`.`org_id` = P_ORG_ID()
						AND `tth`.`ttf_date` >= CURRENT_TIMESTAMP() - INTERVAL 100 DAY) `asd`
			GROUP BY `asd`.`supp_id` , `asd`.`supp_site_id` , `asd`.`ttf_num` , `asd`.`TTF_STATUS` , `asd`.`org_id` , `asd`.`ttf_date` , `asd`.`ttf_return_date` , `asd`.`ttf_giro_date`
			ORDER BY CASE
				WHEN `asd`.`TTF_STATUS` = '' THEN 1
				WHEN `asd`.`TTF_STATUS` = 'S' THEN 2
				WHEN `asd`.`TTF_STATUS` = 'K' THEN 3
				WHEN `asd`.`TTF_STATUS` = 'V' THEN 4
				WHEN `asd`.`TTF_STATUS` = 'R' THEN 0
			END , `asd`.`ttf_num` DESC , `asd`.`ttf_date`
	      )
	    ");
	  }

	  /**
	  * Reverse the migrations.
	  *
	  * @return void
	  */
	  public function down()
	  {
	    DB::statement('DROP VIEW IF EXISTS inq_ttf_view');
	  }
}
