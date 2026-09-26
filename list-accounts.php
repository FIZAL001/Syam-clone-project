<?php
require __DIR__.'/_common.php';
if($_SERVER['REQUEST_METHOD']!=='GET') json_out(['success'=>false,'error'=>'method_not_allowed'],405); admin_required();
$out=[]; foreach(load_users() as $u) $out[]=['id'=>$u['id'],'username'=>$u['username'],'tier'=>$u['tier'],'status'=>$u['status'],'created_at'=>$u['created_at'],'expires_at'=>$u['expires_at']];
json_out(['success'=>true,'accounts'=>$out]);
