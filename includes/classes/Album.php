<?php

class Album {

    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

    public function __construct ($con,$id) {
        $this->con= $con;
        $this->id=$id;

        $albumQuery=mysqli_query($this->con,"select * from albums where id='$this->id'");
        $album=mysqli_fetch_array($albumQuery);

        $this->title=$album['title'];
        $this->artistId=$album['artist'];
        $this->genre=$album['genre'];
        $this->artworkPath=$album['artworkPath'];
    }

    public function getTitle(){
        return $this->title;
    }

    public function getArtist(){
        return new Artist($this->con,$this->artistId);
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getArtworkPath(){
        return $this->artworkPath;
    }

    public function getNoOfSongs(){
        $Query=mysqli_query($this->con,"select id from songs where album='$this->id'");
        return mysqli_num_rows($Query);
    }

    public function getSongIds(){
        $query=mysqli_query($this->con,"select id from songs where album='$this->id' order by albumOrder ASC");
        $array=array();
        while ($row=mysqli_fetch_array($query)){
            array_push($array,$row['id']);
        }
        return $array;
    }
}    

?>