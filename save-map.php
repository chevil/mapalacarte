<?php

function is_ascii( $string = '' ) {
  return ( bool ) preg_match( '/^[_a-zA-Z0-9-]+$/' , $string );
}

  if ( empty($_POST['name']) )
  {
     header('HTTP/1.1 406 Map Name is Mandatory');	  
     exit(-1);
  }

  if ( !is_ascii($_POST['name']) )
  {
     header('HTTP/1.1 406 Map Name should not contains non-ASCII characters');
     exit(-1);
  }
  $mapname = $_POST['name'];
  $filename = 'map-'.$mapname.'.html';
  $gustom = $_POST['gustom'];
  if ( empty($gustom) )
  {
     $gustom = '';
  }


  // if ( !file_put_contents( "./annotations.json", $annotations ) )
  // {
  //    $error = error_get_last();
  //    header('HTTP/1.1 500 Could not store annotations : '.$error['message']);	  
  //    exit(-1);
  // }

  header('HTTP/1.1 200 OK');	  
  $sdir = str_replace( 'save-map.php', '', $_SERVER['REQUEST_URI'] );
  print( 'https://'.$_SERVER['SERVER_NAME'].$sdir.$filename );
  exit(0);

?>
