<?php

class Artist {

    private $con;
    private $id;

    public function __construct ($con,$id) {
        $this->con= $con;
        $this->id=$id;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        $artistQuery=mysqli_query($this->con,"select name from artists where id='$this->id'");
        $artist=mysqli_fetch_array($artistQuery);
        return $artist['name'];
    }

    public function getSongIds(){
        $query=mysqli_query($this->con,"select id from songs where artist='$this->id' order by plays DESC ");
        $array=array();
        while ($row=mysqli_fetch_array($query)){
            array_push($array,$row['id']);
        }
        return $array;
    }
}    

?>