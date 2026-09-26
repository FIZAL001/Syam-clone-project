<?php
function json_out(array $data,int $status=200): never { http_response_code($status); header('Content-Type: application/json; charset=utf-8'); echo json_encode($data,JSON_UNESCAPED_SLASHES); exit; }
function input_data(): array { $raw=file_get_contents('php://input'); $j=json_decode($raw?:'',true); if(is_array($j)) return $j; return $_POST ?: []; }
function users_file(): string { return __DIR__.'/../data/users.json'; }
function load_users(): array { $f=users_file(); if(!file_exists($f)) file_put_contents($f,'[]',LOCK_EX); $j=json_decode(file_get_contents($f),true); return is_array($j)?$j:[]; }
function save_users(array $users): void { file_put_contents(users_file(),json_encode(array_values($users),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),LOCK_EX); }
function admin_required(): void { $expected=getenv('SYAM_ADMIN_KEY') ?: ''; $provided=$_SERVER['HTTP_X_ADMIN_KEY'] ?? ''; if($expected==='' || !hash_equals($expected,$provided)) json_out(['success'=>false,'error'=>'admin_unauthorized'],401); }
