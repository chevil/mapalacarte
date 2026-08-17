<?php

$targetDir = "data/";
$maxFileSize = 100 * 1024 * 1024; // 100MB
$allowedTypes = ['application/json'];

if (!empty($_FILES)) {
    $file = $_FILES['file'];

    // Basic validation
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('HTTP/1.1 400 Upload Error');
        die('HTTP/1.1 400 Upload Error');
    }

    if ($file['size'] > $maxFileSize) {
        header('HTTP/1.1 400 File size is >100MB');
        die('HTTP/1.1 400 File size is >100MB');
    }

    if (!in_array($file['type'], $allowedTypes)) {
        header('HTTP/1.1 400 File size is not a JSON file');
        die('HTTP/1.1 400 File size is not a JSON file');
    }

    // Sanitize filename and avoid collisions
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $file['name'];
    $targetPath = $targetDir.$filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        header('HTTP/1.1 200 File uploaded');
        $sdir = str_replace( 'save-gjson.php', '', $_SERVER['REQUEST_URI'] ); // installation dir
        if ( $_SERVER['HTTPS'] == 'on' )
           print( 'https://'.$_SERVER['SERVER_NAME'].$sdir.$targetPath );
        else
           print( 'http://'.$_SERVER['SERVER_NAME'].$sdir.$targetPath );
    } else {
        header('HTTP/1.1 400 Could not save file (permissions?)');
        die('HTTP/1.1 400 Could not save file (permissions?)');
    }
} else {
    header('HTTP/1.1 400 No file received! weird...');
    die('HTTP/1.1 400 No file received! weird...');
}

?>
