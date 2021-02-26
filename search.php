<?php 

include("includes/includedFiles.php");

if(isset($_GET['term'])){
    $term=urldecode($_GET['term']);
}
else{
    $term="";
}

?>

<div class="searchContainer">
    <h4>Search For</h4>
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start Typing..." onfocus="this.value=this.value">
</div>

<script>
    $(".searchInput").focus();

    $(function(){
       
        $(".searchInput").keyup(function(){
            clearTimeout(timer);

            timer=setTimeout(function(){
                var val=$(".searchInput").val();
                openPage("search.php?term=" + val);
            },2000);
        });
    });
    $(document).ready(function(){
		$(".searchInput").focus();
		var search = $(".searchInput").val();
		$(".searchInput").val('');
		$(".searchInput").val(search);
	})
</script>

<?php if($term=="") exit(); ?>

<div class="trackListContainer borderBottom">
<h2>Songs</h2>
    <ul class="trackList">
        <?php
        
        $songsQuery=mysqli_query($con,"select id from songs where title like '$term%' limit 10");
        
        if(mysqli_num_rows($songsQuery)==0){
            echo "<span class='noResults'>No Results Found</span>";
        }

        $songIdArray=array();
        $i=1;
        while ($row=mysqli_fetch_array($songsQuery)){

            if($i>10){
            break;
            }
            array_push($songIdArray,$row['id']);

            $albumSong=new Song($con,$row['id']);
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

<div class="artistsContainer borderBottom">
    <h2>Artists</h2>
    <?php
    
    $artistsQuery=mysqli_query($con,"select id from artists where name like '$term%' limit 10");
    if(mysqli_num_rows($artistsQuery)==0){
        echo "<span class='noResults'>No Results Found</span>";
    }

    while ($row=mysqli_fetch_array($artistsQuery)){
        $artistFound=new Artist($con,$row['id']);

        echo "<div class='searchResultsRow'>
        <div class='artistName'>
        <span role='link' tabindex='0' onClick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
        " . $artistFound->getName() . "
        </span>
        </div>
        </div>";
    }
    ?>
</div>

<div class="gridViewContainer">
<h2>Albums</h2>
        <?php 
        $albumQuery=mysqli_query($con,"select * from albums where title like '$term%' ");

        if(mysqli_num_rows($albumQuery)==0){
            echo "<span class='noResults'>No Results Found</span>";
        }

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