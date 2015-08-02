<?php

// Connect to database
include_once('mysql.php') ;
$mySQL_connection = mysql_connect('localhost', $mysql_username, $mysql_password) or die('Could not connect: ' . mysql_error()) ;
mysql_select_db($mysql_database) or die('Could not select database') ;

$success = true ;
$youtube_id_in = $_GET['youtube_id'] ;
$youtube_id_in = mysql_real_escape_string($youtube_id_in) ;
if(strlen($youtube_id_in)!=11) $success = false ;
$matched = preg_match('([A-Za-z0-9\-\_]+)', $youtube_id_in) ;
if(0==$matched) $success = false ;
if(false==$success){
  print 'That is not a valid video id!' ;
  exit() ;
}

$query = 'SELECT * FROM ' . $mysql_prefix . 'weirdtube_videos WHERE youtube_id="' . $youtube_id_in . '" LIMIT 1' ; 
$result = mysql_query($query) ;
while($row = mysql_fetch_assoc($result)){
  $success = false ;
  print 'That video is already in the database, but thanks anyway!' ;
  exit() ;
}

$query = 'INSERT INTO ' . $mysql_prefix . 'weirdtube_videos (youtube_id) VALUES("' . $youtube_id_in . '")' ;
$result = mysql_query($query) or die(mysql_error()) ;
print 'Thanks, I added that video to the database!' ;
exit() ;

?>