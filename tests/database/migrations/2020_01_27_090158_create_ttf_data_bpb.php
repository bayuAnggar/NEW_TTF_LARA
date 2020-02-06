<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TtfDataBpb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttf_data_bpb', function (Blueprint $table) {
            $table->bigIncrements('bpb_id');
            $table->unsignedBigInteger('supp_id');
            $table->string('bpb_number');
            $table->unsignedBigInteger('bpb_dpp');
            $table->unsignedBigInteger('bpb_tax');
            $table->string('no_ref')->nullable();
            $table->dateTime('tgl_ref')->nullable();
            $table->string('branch_code');
            $table->unsignedBigInteger('org_id');
            $table->unsignedBigInteger('supp_site_id');
            $table->string('supp_site_code');
            $table->char('used_flag', 1)->comment('Y: YES, N: NO')->default('N');
            $table->string('bpb_bkl')->nullable();
            $table->dateTime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
//            $table->timestamps();

            // $table->foreign('supp_id')->references('supp_id')->on('Suppliers');
            // $table->foreign('branch_code')->references('branch_code')->on('Branches');
            // $table->foreign('org_id')->references('branch_org_id')->on('Branches');
            // $table->foreign('supp_site_code')->references('supp_site_code')->on('Supp_sites');

            $table->index(['bpb_number', 'supp_id','org_id']);
            $table->index(['org_id', 'supp_id','supp_site_code']);
            $table->index('org_id');

            $table->unique(['bpb_number','org_id','supp_site_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttf_data_bpb');
    }
}
