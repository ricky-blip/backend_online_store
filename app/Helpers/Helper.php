<?php

function set_active($uri, $output = 'active')
{
 if( is_array($uri) ) { //$uri menerima data yg diinputkan di sidebar => ['home','/']
   foreach ($uri as $u) {
     if (Route::is($u)) {
       return $output;
     }
   }
 } else {
   if (Route::is($uri)){
     return $output;
   }
 }
}

function format_rupiah($number)
{
    $format = number_format($number,0,0,'.');

    return 'Rp. ' .$format;
}

function status_publish($status)
{
    if($status == '1') {
        $data = 'Publish';
    } else {
        $data = 'Unpublish';
    }

    return $data;
}

function role_user($role)
{
  if($role == '1') {
    $data = 'Admin';
  } else {
    $data = 'Kasir';
  }

  return $data;
}

?>