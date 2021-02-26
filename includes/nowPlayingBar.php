<?php 

$songQuery=mysqli_query($con,"select id from songs order by rand() limit 10");
$resultArray=array();
while($row=mysqli_fetch_array($songQuery)) {
    array_push($resultArray,$row['id']);
}
$jsonArray=json_encode($resultArray);

?>

<script>

$(document).ready(function(){
    var newPlaylist=<?php echo $jsonArray ?>;
    audioElement=new Audio();
    setTrack(newPlaylist[0],newPlaylist,false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove",function(e){
        e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function(){
        mouseDown=true;
    });

    $(".playbackBar .progressBar").mousemove(function(e){
        if(mouseDown){
            timeFromOffset(e,this);
        }
    });

    $(".playbackBar .progressBar").mouseup(function(e){
        timeFromOffset(e,this);
    });

    $(".volumeBar .progressBar").mousedown(function(){
        mouseDown=true;
    });

    $(".volumeBar .progressBar").mousemove(function(e){
        if(mouseDown){
            var percent=e.offsetX / $(this).width();
            if(percent>=0 && percent<=1){
                audioElement.audio.volume=percent;
            }
        }
    });

    $(".volumeBar .progressBar").mouseup(function(e){
        var percent=e.offsetX / $(this).width();
            if(percent>=0 && percent<=1){
                audioElement.audio.volume=percent;
            }
    });

    $(document).mouseup(function(){
        mouseDown=false;
    });

});

function timeFromOffset(mouse,progressBar){
    var percent=mouse.offsetX / $(progressBar).width()* 100;
    var sec=audioElement.audio.duration * (percent /100);
    audioElement.setTime(sec);
}

function prevSong(){
    if(repeat==true){
        audioElement.setTime(0);
        playSong();
        return;
    }
    if(audioElement.audio.currentTime>=3 || currentIndex==0){
        audioElement.setTime(0);
    }
    else{
        currentIndex--;
        setTrack(currentPlaylist[currentIndex],currentPlaylist,true);
    }
}

function nextSong(){
    if(repeat==true){
        audioElement.setTime(0);
        playSong();
        return;
    }
    if(currentIndex==currentPlaylist.length-1){
        currentIndex=0;
    }
    else{
        currentIndex++;
    }
    var trackToPlay=shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay,currentPlaylist,true);
}

function setRepeat(){
    repeat=!repeat;
    var img=repeat?"repeat-active.png":"repeat.png";
    $(".controlButton.repeat img").attr("src","assets/images/icons/" + img);
}

function setMute(){
    audioElement.audio.muted=!audioElement.audio.muted;
    var img=audioElement.audio.muted?"volume-mute.png":"volume.png";
    $(".controlButton.volume img").attr("src","assets/images/icons/" + img);
}

function setShuffle(){
    shuffle=!shuffle;
    var img=shuffle?"shuffle-active.png":"shuffle.png";
    $(".controlButton.shuffle img").attr("src","assets/images/icons/" + img);

    if(shuffle){
        shuffleArray(shufflePlaylist);
        currentIndex=shufflePlaylist.indexOf(audioElement.currentPlaying.id);
    }
    else{
        currentIndex=currentPlaylist.indexOf(audioElement.currentPlaying.id);
    }
}

function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}

function setTrack (trackId,newPlaylist,play){

    if(newPlaylist != currentPlaylist){
        currentPlaylist=newPlaylist;
        shufflePlaylist=currentPlaylist.slice();
        shuffleArray(shufflePlaylist);
    }

    if(shuffle){
        currentIndex=shufflePlaylist.indexOf(trackId);
    }
    else{
        currentIndex=currentPlaylist.indexOf(trackId);
    }
    
    pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php",{songId:trackId},function(data){
        

        var track=JSON.parse(data);
        $(".trackName span").text(track.title);
        
        $.post("includes/handlers/ajax/getArtistJson.php",{artistId:track.artist},function(data){
        var artist=JSON.parse(data);
        $(".trackInfo .artistName span").text(artist.name);
        $(".trackInfo .artistName span").attr("onClick","openPage('artist.php?id=" + artist.id + "')");
        });
        
        $.post("includes/handlers/ajax/getAlbumJson.php",{albumId:track.album},function(data){
        var album=JSON.parse(data);
        $(".content .albumLink img").attr("src",album.artworkPath);
        $(".content .albumLink img").attr("onClick","openPage('album.php?id=" + album.id + "')");
        $(".trackInfo .trackName span").attr("onClick","openPage('album.php?id=" + album.id + "')");
        });
        
        audioElement.setTrack(track);
        if(play){
        playSong();
    }    
    });
    if(play){
        audioElement.play();
    }    
}

function playSong(){

if(audioElement.audio.currentTime==0){
    
    $.post("includes/handlers/ajax/updatePlaysJson.php",{songId:audioElement.currentPlaying.id});
}

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong(){
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

</script>




<div id="nowPlayingBarContainer">
<div id="nowPlayingBar">
<div id="nowPlayingLeft">
    <div class="content" >
        <span class="albumLink">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRuHmklWCsY6sTDgS1Gxv-pZ4aEaCOgtvgOzg&usqp=CAU" class="albumArtwork">
        </span>
        <div class="trackInfo">
            <span class="trackName">
                <span role="link" tabindex="0"></span>
            </span>
            <span class="artistName">
                <span role="link" tabindex="0"></span>
            </span>
        </div>
    </div>
</div>
<div id="nowPlayingCentre">
    <div class="content playerControls">
        <div class="buttons">
            <button class="controlButton shuffle" title="Shuffle" onClick="setShuffle()">
                <img src="assets/images/icons/shuffle.png" alt="Shuffle">
            </button>
            <button class="controlButton previous" title="Previous" onClick="prevSong()">
                <img src="assets/images/icons/previous.png" alt="Previous">
            </button>
            <button class="controlButton play" title="Play" onClick="playSong()">
                <img src="assets/images/icons/play.png" alt="Play">
            </button>
            <button class="controlButton pause" title="Pause" style="display:none" onClick="pauseSong()">
                <img src="assets/images/icons/pause.png" alt="Pause">
            </button>
            <button class="controlButton next" title="Next" onClick="nextSong()">
                <img src="assets/images/icons/next.png" alt="Next">
            </button>
            <button class="controlButton repeat" title="Repeat" onClick="setRepeat()">
                <img src="assets/images/icons/repeat.png" alt="Repeat">
            </button>
        </div>
        <div class="playbackBar">
            <span class="progressTime current">0.00</span>
            <div class="progressBar">
                <div class="progressBarBg">
                    <div class="progress"></div>
                </div>
            </div>
            <span class="progressTime remaining">0.00</span>
        </div>
    </div>
</div>
<div id="nowPlayingRight">
    <div class="volumeBar">
    <button class="controlButton volume" title="Volume" onClick="setMute()">
        <img src="assets/images/icons/volume.png" alt="Volume">
    </button>
    <div class="progressBar">
        <div class="progressBarBg">
            <div class="progress"></div>
        </div>
    </div>
    </div>
</div>
</div>
</div>