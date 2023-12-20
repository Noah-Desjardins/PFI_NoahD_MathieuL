<?php
require 'php/sessionManager.php';
require 'DAL/PhotosCloudDB.php';

userAccess();
if (!isset($_GET["photoId"])) 
    redirect("photosList.php");

$photoId = (int)$_GET["photoId"];
$userId = (int)$_SESSION["currentUserId"];

$likeExist = LikesTable()->selectWhere("PhotoId = $photoId AND UserId = $userId");
$exist = false;
    if ($likeExist != null){
        $exist = true;
        $id = $likeExist[0]->Id;
        LikesTable()->delete($id);
    }
if (!$exist){
    $newLike = new Like;
    $newLike->setPhotoId($photoId);
    $newLike->setUserId($userId);
    LikesTable()->insert($newLike);
}
redirect("photoDetails.php?id=$photoId");