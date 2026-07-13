<?php

$SKELETON = 'skeleton.html';

function is_ascii( $string = '' ) {
  return ( bool ) preg_match( '/^[_a-zA-Z0-9-]+$/' , $string );
}

  if ( empty($_POST['name']) )
  {
     header('HTTP/1.1 406 Map Name is Mandatory');	  
     exit(-1);
  }

  if ( empty($_POST['theme']) )
  {
     header('HTTP/1.1 406 Map Theme is Mandatory');	  
     exit(-1);
  }
  $theme = $_POST['theme'];

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

  $templette = file_get_contents ($SKELETON);
  $templute = str_replace( '// CUSTOM CODE', "// CUSTOM CODE\n".$gustom, $templette );
  $tempflute = str_replace( 'THEME', $theme, $templute );
  $rsize = file_put_contents($filename, $tempflute);

  if ($rsize) {
    header('HTTP/1.1 200 OK');	  
    $sdir = str_replace( 'save-map.php', '', $_SERVER['REQUEST_URI'] );
    print( 'https://'.$_SERVER['SERVER_NAME'].$sdir.$filename );
    exit(0);
  } else {
    header('HTTP/1.1 406 Map could not be saved, check permissions ');
    exit(-1);
  }


?>
