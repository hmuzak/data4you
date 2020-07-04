<?php

function uploadFiles($myClient, $myUrl){
    if (isset($_GET['code'])) {
        $_SESSION['accessToken'] = $myClient->authenticate($_GET['code']);
        header('location:'.$myUrl);exit;
    } elseif (!isset($_SESSION['accessToken'])) {
        $myClient->authenticate();
    }
    $files= array();
    $dir = dir('files');
    while ($file = $dir->read()) {
        if ($file != '.' && $file != '..') {
            $files[] = $file;
        }
    }
    $dir->close();
    $parentFolder = new Google_ParentReference();
    $parentFolder->setId('1Jb95CJJfKlHWK82fn9uTXmWfPYjFr0tt'); //Folder called as "Data4you" in gDrive.

    if (isset($_POST['submit-btn'])) {
        $myClient->setAccessToken($_SESSION['accessToken']);
        $service = new Google_DriveService($myClient);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file = new Google_DriveFile();
        $file->setParents(array($parentFolder));
        foreach ($files as $file_name) {
            $file_path = 'files/'.$file_name;
            $mime_type = finfo_file($finfo, $file_path);
            $file->setTitle($file_name);
            $file->setDescription('This is a '.$mime_type.' document');
            $file->setMimeType($mime_type);
            $service->files->insert(
                $file,
                array(
                    'data' => file_get_contents($file_path),
                    'mimeType' => $mime_type
                )
            );
        }
        finfo_close($finfo);
        header('location:'.$myUrl);exit;
    }
}

