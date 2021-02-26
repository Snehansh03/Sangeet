var currentPlaylist=[];
var shufflePlaylist=[];
var tempPlaylist=[];
var audioElement;
var mouseDown=false;
var currentIndex=0;
var repeat=false;
var shuffle=false;
var userLoggedIn;
var timer;

$(document).click(function(click){
    var target=$(click.target);
    if(!target.hasClass("item") && !target.hasClass("optionsButton")){
        hideOptionsMenu();
    }
});

$(window).scroll(function(){
    hideOptionsMenu();
});

$(document).on("change","select.playlist",function(){
    var select=$(this);
    var playlistId=select.val();
    var songId=select.prev(".songId").val();

    $.post("includes/handlers/ajax/addToPlaylistJson.php",{playlistId:playlistId , songId:songId}).done(function(error){
        if(error !=""){
            alert(error);
            return;
        }
        else{
            alert("Added Successfully!");
        }
        hideOptionsMenu();
        select.val("");
    });
})

function updateEmail(emailClass){
    var emailValue=$("." + emailClass).val();

    $.post("includes/handlers/ajax/updateEmailJson.php",{email:emailValue,username:userLoggedIn}).done(function(response){
        $("." + emailClass).nextAll(".message").text(response);
    })
}

function updatePassword(oldPasswordClass,newPassword1Class,newPassword2Class){
    var oldPasswordValue=$("." + oldPasswordClass).val();
    var newPassword1Value=$("." + newPassword1Class).val();
    var newPassword2Value=$("." + newPassword2Class).val();

    $.post("includes/handlers/ajax/updatePasswordJson.php",{oldPassword:oldPasswordValue,newPassword1:newPassword1Value,newPassword2:newPassword2Value,username:userLoggedIn}).done(function(response){
        $("." + oldPasswordClass).nextAll(".message").text(response);
    })
}

function logout(){
    $.post("includes/handlers/ajax/logout.php",function(){
        location.reload();
    })
}

function openPage(url){

    if(timer !=null){
        clearTimeout(timer);
    }

    if(url.indexOf("?")==-1){
        url=url + "?";
    }

    var encodedUrl=encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainViewContainer").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null,null,url);
}

function removeFromPlaylist(button,playlistId){
    var songId=$(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/removeFromPlaylistJson.php",{playlistId:playlistId,songId:songId}).done(function(error){
        if(error !=""){
            alert(error);
            return;
        }
        openPage('playlist.php?id='+playlistId);
    });
}

function createPlaylist() {
    var popup=prompt("Enter Playlist Name");
    if(popup !=null){
        $.post("includes/handlers/ajax/createPlaylistJson.php",{name:popup , username:userLoggedIn}).done(function(error){
            if(error !=""){
                alert(error);
                return;
            }
            openPage('yourmusic.php');
        });
    }
}

function deletePlaylist(playlistId){
    var prompt=confirm("Are You Sure!");
    if(prompt){
        $.post("includes/handlers/ajax/deletePlaylistJson.php",{playlistId:playlistId}).done(function(error){
            if(error !=""){
                alert(error);
                return;
            }
            openPage('yourmusic.php');
        });
    }
}

function hideOptionsMenu(){
    var menu=$(".optionsMenu");
    if(menu.css("display")!="none"){
        menu.css("display","none");
    }
}

function showOptionsMenu (button) {
    
    var songId=$(button).prevAll(".songId").val();
    var menu=$(".optionsMenu");
    var menuWidth=menu.width();
    menu.find(".songId").val(songId);
    var scrollTop=$(window).scrollTop();
    var elementOffset=$(button).offset().top;
    var top=elementOffset-scrollTop;
    var left=$(button).position().left;

    menu.css({"top":top+"px","left":left-menuWidth+"px","display":"inline"});

}

function formatTime (seconds){
    var time=Math.round(seconds);
    var min=Math.floor(time/60);
    var sec=time-(min*60);

    var zero=(sec<10)?"0":"";
    return min + ":" + zero + sec;

}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));
    var progress=audio.currentTime/audio.duration *100;
    $(".playbackBar .progress").css("width",progress+"%");
}

function updateVolumeProgressBar(audio){
    var volume=audio.volume *100;
    $(".volumeBar .progress").css("width",volume + "%");
}

function playFirstSong(){
    setTrack(tempPlaylist[0],tempPlaylist,true);
}

function Audio() {
  
    this.currentPlaying;
    this.audio=document.createElement('audio');

    this.audio.addEventListener("ended",function(){
        nextSong();
    })

    this.audio.addEventListener("canplay",function(){
        var duration=formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate",function(){
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange",function(){
        updateVolumeProgressBar(this);
    })

    this.setTrack=function(track){
        this.currentPlaying=track;
        this.audio.src=track.path;
    }

    this.play=function(){
        this.audio.play();
    }

    this.pause=function(){
        this.audio.pause();
    }

    this.setTime=function(seconds){
        this.audio.currentTime=seconds;
    }
}

