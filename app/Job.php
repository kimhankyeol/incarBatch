<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //잡 테이블 기본설정
    protected $table = 'OnlineBatch_JOB';
    protected $primaryKey = 'Job_Seq';
}
