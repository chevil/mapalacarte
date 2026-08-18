<?php

$SKELETON = 'skeleton.html';
$INDEX = 'index.html';

function is_ascii( $string = '' ) {
  return ( bool ) preg_match( '/^[_a-zA-Z0-9-éèàûôçâ]+$/' , $string );
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
  $filename = 'maps/map-'.$mapname.'.html';
  $ifilename = 'index-'.$mapname.'.html';
  $gustom = $_POST['gustom'];
  if ( empty($gustom) )
  {
     $gustom = '';
  }
  $addCss = $_POST['addCss'];
  if ( empty($addCss) )
  {
     $addCss = '';
  }

  $rsize = 0;

  // save the map
  $templette = file_get_contents ($SKELETON);
  $templute = str_replace( '// CUSTOM CODE', "// CUSTOM CODE\n".$gustom, $templette );
  $template = str_replace( '// ADDED CSS', "// ADDED CSS\n".$addCss, $templute );
  $tempflute = str_replace( 'THEME', $theme, $template );
  $rsize = file_put_contents($filename, $tempflute);

  // save the index
  $templette = file_get_contents ($INDEX);
  $templute = str_replace( '// CUSTOM CODE', addslashes($gustom), $templette );
  $template = str_replace( '// ADDED CSS', addslashes($addCss), $templute );
  $tempflute = str_replace( 'THEME', $theme, $template );
  $rsize = file_put_contents($ifilename, $tempflute);

  if ($rsize) {
    header('HTTP/1.1 200 OK');	  
    $sdir = str_replace( 'save-map.php', '', $_SERVER['REQUEST_URI'] );
    if ( $_SERVER['HTTPS'] == 'on' )
       print( 'https://'.$_SERVER['SERVER_NAME'].$sdir.$filename );
    else
       print( 'http://'.$_SERVER['SERVER_NAME'].$sdir.$filename );
    exit(0);
  } else {
    header('HTTP/1.1 406 Map could not be saved, check permissions ');
    exit(-1);
  }


?>
