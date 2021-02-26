<?php

class Playlist {

    private $con;
    private $id;
    private $name;
    private $owner;

    public function __construct ($con,$data) {


        if(!is_array($data)){
            $query=mysqli_query($con,"select * from playlists where id='$data'");
            $data=mysqli_fetch_array($query);
        }

        $this->con= $con;
        $this->id=$data['id'];
        $this->name=$data['name'];
        $this->owner=$data['owner'];
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getOwner(){
        return $this->owner;
    }

    public function getNoOfSongs(){
        $query=mysqli_query($this->con,"select songId from playlistSongs where playlistId='$this->id' ");
        return mysqli_num_rows($query);
    }

    public function getSongIds(){
        $query=mysqli_query($this->con,"select songId from playlistSongs where playlistId='$this->id' order by playlistOrder DESC");
        $array=array();
        while ($row=mysqli_fetch_array($query)){
            array_push($array,$row['songId']);
        }
        return $array;
    }

    public static function getPlaylistDropdown($con,$username){
        $dropdown='<select class="item playlist">
        <option value="">Add To Playlist</option>';

        $query=mysqli_query($con,"select id,name from playlists where owner='$username'");
        while($row=mysqli_fetch_array($query)){
            $id=$row['id'];
            $name=$row['name'];
            $dropdown=$dropdown . "<option value='$id'>$name</option>" ;
        }

        return $dropdown . "</select>" ;
    }

}

?>