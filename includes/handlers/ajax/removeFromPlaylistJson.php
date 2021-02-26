<?php

include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){
    $playlistId=$_POST['playlistId'];
    $songId=$_POST['songId'];
    
    $query=mysqli_query($con,"delete from playlistSongs where playlistId='$playlistId' and songId='$songId'");
    return "";
}
else{
    echo "Playlist Not Deleted!";
}

?>

