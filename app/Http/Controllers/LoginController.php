<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;


class LoginController extends Controller{

    public function loginCheck(Request $request){
        $UserId = $request->input('UserId');
        $UserPwd = $request->input('UserPwd');

        $count = DB::table('User')->where('UserId',$UserId)->where('UserPwd',$UserPwd)->count();
        
        return response()->json(array('count'=>$count));
    }
}
?>