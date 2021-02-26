<?php
include("includes/includedFiles.php");
?>

<div id="mainContent">
    <h1 class="pageHeadingBg">You Might Like</h1>
    <div class="gridViewContainer">
        <?php 
        $albumQuery=mysqli_query($con,"select * from albums order by rand() limit 10");

        while($row=mysqli_fetch_array($albumQuery)){
            echo "<div class='gridViewItem'>
            <span role='link' tabindex='0' onClick='openPage(\"album.php?id=" . $row['id'] . "\")'>
            <img src='" . $row['artworkPath'] . "'>
            <div class='gridViewInfo'>" . $row['title'] . "</div>
            </span>
            </div>";
        }
        ?>
    </div>
</div>

