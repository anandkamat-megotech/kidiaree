<?php

require 'vendor/autoload.php';
putenv(GOOGLE_APPLICATION_CREDENTIALS_PATH);

use Google\Cloud\Storage\StorageClient;

class ServiceDeleteUserProfilePic{

    function delete_object($bucketName, $objectName, $options = [])
    {
        $storage = new StorageClient();
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->delete();
        // printf('Deleted gs://%s/%s' . PHP_EOL, $bucketName, $objectName);
    }
    
    
    public function serve($db, $idUser) {

        $sql = "Update usersmaster SET profilePictureUrl = 'https://storage.googleapis.com/bricketc-storage/profile_pictures/profile_picture_71_1671705548.JPEG' WHERE id = $idUser;";
        $statement = query_execute($db, $sql);
		return true;


        
    }
    
}

?>