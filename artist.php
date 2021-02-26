<?php 

include("includes/includedFiles.php");

if (isset($_GET['id'])){
    $artistId=$_GET['id'];
}
else {
    header("Location:index.php");
}

$artist=new Artist($con,$artistId);

?>

<div class="entityInfo borderBottom">
<div class="centerSection">
<div class="artistInfo">
<h1 class="artistName"><?php echo $artist->getName() ?></h1>
<div class="headerButtons">
<button class="button green" onClick="playFirstSong()">PLAY</button>
</div>
</div>
</div>
</div>

<div class="trackListContainer borderBottom">
<h2>Popular</h2>
    <ul class="trackList">
        <?php 
        $songIdArray=$artist->getSongIds();
        $i=1;
        foreach($songIdArray as $songId){

            if($i>5){
            break;
            }

            $albumSong=new Song($con,$songId);
            $albumArtist=$albumSong->getArtist();

            echo "<li class='trackListRow'>
            <div class='trackCount'>
            <img src='assets/images/icons/play-white.png' onClick='setTrack(\"" . $albumSong->getId() . "\",tempPlaylist,true)'>
            <span class='trackNumber'>$i</span>
            </div>
            <div class='trackInfo'>
            <span class='trackName'>" . $albumSong->getTitle() . "</span>
            <span class='artistName'>" . $albumArtist->getName() . "</span>
            </div>
            <div class='trackOptions'>
            <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
            <img class='optionsButton' src='assets/images/icons/more.png' onClick='showOptionsMenu(this)'>
            </div>
            <div class='trackDuration'>
            <span class='duration'>" . $albumSong->getDuration(). "</span>
            </div>
            </li>";
            $i++;
        }
        ?>

        <script>
            var tempSongIds='<?php echo json_encode($songIdArray); ?>';
            tempPlaylist=JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<div class="gridViewContainer">
<h2>Albums</h2>
        <?php 
        $albumQuery=mysqli_query($con,"select * from albums where artist='$artistId'");

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

<nav class="optionsMenu">
<input type="hidden" class="songId">
<?php echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUserName()); ?>
</nav>