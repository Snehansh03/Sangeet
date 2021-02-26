<?php

include("../../config.php");

if(isset($_POST['playlistId'])){
    $playlistId=$_POST['playlistId'];
    
    $playlistQuery=mysqli_query($con,"delete from playlists where id='$playlistId'");
    $songsQuery=mysqli_query($con,"delete from playlistSongs where playlistId='$playlistId'");
    return "";
}
else{
    echo "Playlist Not Deleted!";
}

?>

