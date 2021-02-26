<?php 
 include("includes/includedFiles.php");

 ?>

 <div class="playlistsContainer">
     <div class="gridViewContainer">
         <h2>Playlists</h2>
         <div class="buttonItems">
             <button class="button green" onClick="createPlaylist()">New Playlist</button>
         </div>

         <?php 
         $username=$userLoggedIn->getUsername();

        $playlistQuery=mysqli_query($con,"select * from playlists where owner='$username' ");

        if(mysqli_num_rows($playlistQuery)==0){
            echo "<span class='noResults'>No Results Found</span>";
        }

        while($row=mysqli_fetch_array($playlistQuery)){

            $playlist=new Playlist($con,$row);

            echo "<div class='gridViewItem' role='link' tabindex='0' onClick='openPage(\"playList.php?id=" . $playlist->getId() . "\")'>
            <div class='playlistImage'>
            <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRuHmklWCsY6sTDgS1Gxv-pZ4aEaCOgtvgOzg&usqp=CAU'>
            </div>
            <div class='gridViewInfo'>" . $playlist->getName() . "</div>
            </span>
            </div>";
        }
        ?>

     </div>

 </div>