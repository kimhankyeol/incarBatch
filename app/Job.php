<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //잡 테이블 기본설정
    protected $table = 'JOB';
    protected $primaryKey = 'job_seq';
}
