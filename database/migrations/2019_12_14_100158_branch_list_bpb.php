<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BranchListBpb extends Migration
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
        CREATE VIEW branch_list_bpb AS
        (
          SELECT 
              `tdb`.`supp_site_code` AS `SUPP_SITE_CODE`,
              `sss`.`supp_site_alt_name` AS `SUPP_SITE_NAME`,
              COUNT(0) AS `TOTAL_BPB`
          FROM
              (`ttf_data_bpb` `tdb`
              JOIN `supp_sites` `sss`)
          WHERE
              `tdb`.`supp_site_id` = `sss`.`supp_site_id`
                  AND `tdb`.`org_id` = `sss`.`supp_org_id`
                  AND `tdb`.`supp_id` = P_SUPP_ID()
                  AND `tdb`.`org_id` = P_ORG_ID()
                  AND `tdb`.`used_flag` = 'N'
                  AND TO_DAYS(CURRENT_TIMESTAMP()) - TO_DAYS(`tdb`.`bpb_date`) <= 100
          GROUP BY `tdb`.`supp_site_code` , `sss`.`supp_site_alt_name`
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
	    DB::statement('DROP VIEW IF EXISTS branch_list_bpb');
	  }
}
