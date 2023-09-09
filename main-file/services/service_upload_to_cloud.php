<?php

require 'vendor/autoload.php';
putenv(GOOGLE_APPLICATION_CREDENTIALS_PATH);

use Google\Cloud\Storage\StorageClient;


class ServiceUploadToCloud{
    
    
    public function serve($file, $uploadfile, $folderName) {

        $filename = basename($uploadfile);
        $storage = new StorageClient();

        $objectName = "";
        if($folderName == ''){
            $objectName = $filename;
        }else{
            $objectName = $folderName."/".$filename;
        }

        $options = [
            'name' => $objectName
        ];

        $bucket = $storage->bucket('bricketc-storage');

        // Upload a file to the bucket folder.
        $bucket -> upload(
            fopen($uploadfile, 'r'),
            $options
        );
        unlink($file);

        $publicUrl = '';
        if($folderName == ''){
            $publicUrl = 'https://storage.googleapis.com/bricketc-storage/'.$filename;
        }else{
            $publicUrl = 'https://storage.googleapis.com/bricketc-storage/'.$folderName.'/'.$filename;
        }

        $publicUrl = str_replace(' ', '%20', $publicUrl);
        
        return $publicUrl;

        
    }
    
}

?>