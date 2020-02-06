<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ttf_data_bpb extends Model
{
    //
    protected $table = 'ttf_data_bpb'; //isi jika nama table tidak sesuai dengan nama "JAMAK" dari nama model (MODEL: USER :: TABLE: USERS)
    protected $primaryKey = 'bpb_id'; // isi jika PRIMARY_KEY bukan KOLOM "ID"/"id"
}
