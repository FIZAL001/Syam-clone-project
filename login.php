<?php
require __DIR__.'/_common.php';
if($_SERVER['REQUEST_METHOD']!=='POST') json_out(['success'=>false,'error'=>'method_not_allowed'],405);
$in=input_data(); $user=trim((string)($in['username']??$in['user']??'')); $pass=(string)($in['password']??$in['pass']??'');
if($user===''||$pass==='') json_out(['success'=>false,'error'=>'account_not_found'],401);
$users=load_users();
foreach($users as $u){ if(strtolower($u['username'])!==strtolower($user)) continue;
 if(($u['status']??'ACTIVE')!=='ACTIVE') json_out(['success'=>false,'error'=>'banned'],403);
 if((int)($u['expires_at']??0)<time()) json_out(['success'=>false,'error'=>'subscription_expired'],403);
 if(!password_verify($pass,$u['password_hash'])) break;
 $token=bin2hex(random_bytes(32));
 json_out(['success'=>true,'message'=>'login_successful','token'=>$token,'access_token'=>$token,'user'=>['username'=>$u['username'],'tier'=>$u['tier'],'premium'=>in_array($u['tier'],['PREMIUM','VIP'],true),'expires_at'=>$u['expires_at']]]);
}
json_out(['success'=>false,'error'=>'account_not_found','message'=>'Username and Password not accepted'],401);
