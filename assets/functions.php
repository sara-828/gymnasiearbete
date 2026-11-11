<?php

require_once 'config/db.php';


function getUsers() {
    $sql = "select * from users";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function login($username, $password){
  global $forum;

  $sql = "SELECT * FROM users WHERE username = :username";

  $stmt = $forum->prepare($sql);
  $stmt->bindValue(':username', $username);
  $stmt->execute();

  if ($stmt->rowCount()>0){

   $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if(password_verify($password, $user['password'])){
   return true;
  } else {
   return false;
  }

  }else {
      return false;
  }
}
 
function addUser($felt) {
    global $forum;

    $sql = "INSERT INTO users(username, firstname, lastname, email, password) VALUES (:username,:firstname,:lastname,:email,:password)";
   //  UPDATE `user` SET `username`='[value-1]',`name`='[value-2]',`email`='[value-3]',`password`='[value-4]' WHERE 1

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $felt['username']);
    $stmt->bindValue(':firstname', $felt['firstname']);
    $stmt->bindValue(':lastname', $felt['lastname']);
    $stmt->bindValue(':email', $felt['email']);
    $stmt->bindValue(':password', $felt['password']);
/*
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }*/
        try {
            return $stmt->execute();

        }
        catch(Exception $e){
            return false;
        }
            
}

function changeUser($felt) {
    global $forum;

   $sql = "UPDATE `users` 
            SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, password = :password WHERE user_id=:user_id";

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $felt['username']);
    $stmt->bindValue(':firstname', $felt['firstname']);
    $stmt->bindValue(':lastname', $felt['lastname']);
    $stmt->bindValue(':email', $felt['email']);
    $stmt->bindValue(':password', $felt['password']);
    $stmt->bindValue(':user_id', $felt['user_id'], PDO::PARAM_STR);

        try {
            return $stmt->execute();
        }
        catch(Exception $e){
            return false;
        }
            
}
function deleteUser($user_id){
    global $forum;

    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    return $stmt->execute();
}


function addFavoriteArtist ($felt){
    global $forum;

    $sql = "INSERT INTO favoriteartists(artist_id, user_id) VALUES (:artist_id, :user_id)";
    //INSERT INTO `favoriteartists`(`artist_id`, `user_id`) VALUES ('[value-1]','[value-2]')
    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':artist_id', $felt['artist_id']);
    $stmt->bindValue(':user_id', $felt['user_id']);
        try {
            return $stmt->execute();
        }
        catch(Exception $e){
            return false;
        }
            
}

function getFavoriteArtists ($user_id){
global $forum;

    $sql = "SELECT * FROM favoriteartists WHERE user_id = :user_id";

    $stmt = $forum->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    return $stmt;

}

function addTrip (){
    global $forum;

    $sql = "INSERT INTO trip(trip_id, event_id, createdby, startdate, enddate) VALUES (:trip_id, :event_id, :createdby, :startdate, :enddate)";
    //INSERT INTO `trip`(`trip_id`, `event_id`, `createdby`, `startdate`, `enddate`) VALUES 
    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':trip_id', $felt['trip_id']);
    $stmt->bindValue(':event_id', $felt['event_id']);
    $stmt->bindValue(':createdby', $felt['createdby']);
    $stmt->bindValue(':startdate', $felt['startdate']);
    $stmt->bindValue(':enddate', $felt['enddate']);
        try {
            return $stmt->execute();

        }
        catch(Exception $e){
            return false;
        }       
}

function addevent(){

}

function getTrips(){
     $sql = "select * from trip";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function getArtists(){
     $sql = "select * from artists";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}  
function addArtist($data){
    global $forum;

    $sql = "INSERT INTO artists(artistname, genre, image) VALUES (:artistname, :genre, :image)";
    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':artistname', $data['artistname']);
    $stmt->bindValue(':genre', $data['genre']);
    $stmt->bindValue(':image', $data['image']);

    try {
        return $stmt->execute();
    }
    catch(Exception $e){
        return false;
    }
}
function deleteArtist($artist_id){
    global $forum;

    $sql = "DELETE FROM artists WHERE artist_id = :artist_id";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':artist_id', $artist_id);
    return $stmt->execute();
}
    ?>

  