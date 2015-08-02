<?php

// Connect to database
include_once('mysql.php') ;
$mySQL_connection = mysql_connect('localhost', $mysql_username, $mysql_password) or die('Could not connect: ' . mysql_error()) ;
mysql_select_db($mysql_database) or die('Could not select database') ;

// Choose two rows at random that do not match the ids submitted.
$youtube_ids_in = $_GET['youtube_ids'] ;
$youtube_ids_in = mysql_real_escape_string($youtube_ids_in) ;
$matches = array() ;
if(strlen($youtube_ids_in)==23){
  $youtube_ids = explode(';', $youtube_ids_in) ;
  $matched = preg_match('([A-Za-z0-9\-\_]+)', $youtube_ids_in, $matches) ;
}

$query = 'SELECT * FROM ' . $mysql_prefix . 'weirdtube_videos ORDER BY RAND() LIMIT 4' ; 
$result = mysql_query($query) ;
$youtube_ids_out = array() ;
$wins_out        = array() ;
$losses_out      = array() ;
while($row = mysql_fetch_assoc($result)){
  $fail = false ;
  for($i=0 ; $i<count($matches) ; $i++){
    if($matches[$i]==$row['youtube_id']){
      $fail = true ;
      break ;
    }
  }
  if($fail==false){
    $youtube_ids_out[] = $row['youtube_id'] ;
    $wins_out[]        = $row['win'       ] ;
    $losses_out[]      = $row['lose'      ] ;
  }
  if(count($youtube_ids_out)==2) break ;
}

$vote_up_in   = mysql_real_escape_string($_GET['vote_up'  ]) ;
$vote_down_in = mysql_real_escape_string($_GET['vote_down']) ;
$matched_vote_up   = preg_match('([A-Za-z0-9\-\_]+)', $vote_up_in  ) ;
$matched_vote_down = preg_match('([A-Za-z0-9\-\_]+)', $vote_down_in) ;
if($matched_vote_up && $matched_vote_down){
  // Upvote the relevant video
  $query = 'SELECT * FROM ' . $mysql_prefix . 'weirdtube_videos WHERE youtube_id="' . $vote_up_in . '" LIMIT 1' ;
  $result = mysql_query($query) ;
  while($row = mysql_fetch_assoc($result)){
    $n_up = $row['win'] ;
    $query = 'UPDATE ' . $mysql_prefix . 'weirdtube_videos SET win=' . ($n_up+1) . ' WHERE youtube_id="' . $vote_up_in . '"' ;
    mysql_query($query) ;
    echo mysql_error() ;
    break ;
  }
  // Downvote the relevant video
  $query = 'SELECT * FROM ' . $mysql_prefix . 'weirdtube_videos WHERE youtube_id="' . $vote_down_in . '" LIMIT 1' ;
  $result = mysql_query($query) ;
  while($row = mysql_fetch_assoc($result)){
    $n_down = $row['lose'] ;
    $query = 'UPDATE ' . $mysql_prefix . 'weirdtube_videos SET lose=' . ($n_down+1) . ' WHERE youtube_id="' . $vote_down_in . '"' ;
    mysql_query($query) ;
    break ;
  }
}

if(count($youtube_ids_out)>=2){
  echo $youtube_ids_out[0] , ';' , $youtube_ids_out[1] , '%' , $wins_out[0] , ',' , $wins_out[1] , ',' , $losses_out[0] , ',' , $losses_out[1] ;
}
else{
  print 'There was a database error' ;
  exit() ;
}

?>