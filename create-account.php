<?php
require __DIR__.'/_common.php';
if($_SERVER['REQUEST_METHOD']!=='POST') json_out(['success'=>false,'error'=>'method_not_allowed'],405);
admin_required(); $in=input_data();
$user=trim((string)($in['username']??'')); $pass=(string)($in['password']??''); $tier=strtoupper((string)($in['tier']??'BASIC')); $days=(int)($in['days']??30);
if(!preg_match('/^[A-Za-z0-9_.-]{5,32}$/',$user)) json_out(['success'=>false,'error'=>'username_invalid'],422);
if(strlen($pass)<6) json_out(['success'=>false,'error'=>'password_invalid'],422);
if(!in_array($tier,['BASIC','PREMIUM','VIP'],true)) json_out(['success'=>false,'error'=>'tier_invalid'],422);
if($days<1||$days>3650) json_out(['success'=>false,'error'=>'days_invalid'],422);
$users=load_users(); foreach($users as $u) if(strtolower($u['username'])===strtolower($user)) json_out(['success'=>false,'error'=>'username_conflict','message'=>'username_conflict'],409);
$now=time(); $account=['id'=>bin2hex(random_bytes(12)),'username'=>$user,'password_hash'=>password_hash($pass,PASSWORD_DEFAULT),'tier'=>$tier,'status'=>'ACTIVE','created_at'=>$now,'expires_at'=>$now+$days*86400]; $users[]=$account; save_users($users);
json_out(['success'=>true,'message'=>'account_created','account'=>['id'=>$account['id'],'username'=>$user,'tier'=>$tier,'status'=>'ACTIVE','expires_at'=>$account['expires_at']]]);
