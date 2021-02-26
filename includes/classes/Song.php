<?php

class Song {

    private $con;
    private $id;
    private $title;
    private $artistId;
    private $albumId;
    private $genre;
    private $duration;
    private $path;

    public function __construct ($con,$id) {
        $this->con= $con;
        $this->id=$id;

        $songQuery=mysqli_query($this->con,"select * from songs where id='$this->id'");
        $song=mysqli_fetch_array($songQuery);

        $this->title=$song['title'];
        $this->artistId=$song['artist'];
        $this->albumId=$song['album'];
        $this->genre=$song['genre'];
        $this->duration=$song['duration'];
        $this->path=$song['path'];
    }

    public function getTitle(){
        return $this->title;
    }

    public function getId(){
        return $this->id;
    }

    public function getArtist(){
        return new Artist($this->con,$this->artistId);
    }

    public function getAlbum(){
        return new Album($this->con,$this->albumId);
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getDuration(){
        return $this->duration;
    }

    public function getPath(){
        return $this->path;
    }

}    

?>