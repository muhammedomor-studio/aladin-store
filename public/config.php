<?php
define('API_BASE', rtrim(getenv('API_BASE_URL') ?: 'https://aladin-e-commerce-api.onrender.com','/'));
define('ADMIN_PASSWORD', getenv('ADMIN_PASSWORD') ?: '');
define('SYNC_SECRET', getenv('SYNC_SECRET') ?: '');
define('CACHE_FILE', sys_get_temp_dir().'/aladin_products_cache.json');
function api_get($path) {
  $url=API_BASE.'/'.ltrim($path,'/');
  $ctx=stream_context_create(['http'=>['timeout'=>20,'ignore_errors'=>true,'header'=>"Accept: application/json\r\n"]]);
  $raw=@file_get_contents($url,false,$ctx);
  if($raw===false) return ['_error'=>'API unavailable'];
  $data=json_decode($raw,true);
  return $data ?? ['_error'=>'Invalid API response'];
}
function products_data($force=false) {
  if(!$force && file_exists(CACHE_FILE) && time()-filemtime(CACHE_FILE)<300) {
    $d=json_decode(file_get_contents(CACHE_FILE),true); if(is_array($d)) return $d;
  }
  $d=api_get('api/products');
  if(!isset($d['_error'])) @file_put_contents(CACHE_FILE,json_encode($d));
  return $d;
}
function esc($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
