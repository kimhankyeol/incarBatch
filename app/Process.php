<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    //잡 테이블 기본설정
    protected $table = 'OnlineBatch_Process';
    protected $primaryKey = 'P_Seq';
}
