<?php 
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){
    $playlistId=$_POST['playlistId'];
    $songId=$_POST['songId'];
    
    $orderQuery=mysqli_query($con,"select max(playlistOrder)+1 as playlistOrder from playlistSongs where playlistId='$playlistId'");
    $row=mysqli_fetch_array($orderQuery);
    $order=$row['playlistOrder'];
    
    $query=mysqli_query($con,"insert into playlistSongs values ('','$songId','$playlistId','$order')");

}
else{
    echo "Song Not Added!";
}

?>