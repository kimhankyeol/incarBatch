<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    //잡 테이블 기본설정
    protected $table = 'Process';
    protected $primaryKey = 'p_seq';
}
