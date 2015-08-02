<?php

// Connect to database
include_once('mysql.php') ;
$mySQL_connection = mysql_connect('localhost', $mysql_username, $mysql_password) or die('Could not connect: ' . mysql_error()) ;
mysql_select_db($mysql_database) or die('Could not select database') ;

$query = 'SELECT * FROM ' . $mysql_prefix . 'weirdtube_videos ORDER BY RAND() LIMIT 2' ; 
$result = mysql_query($query) ;
$youtube_ids_out = array() ;
$wins_out        = array() ;
$losses_out      = array() ;
while($row = mysql_fetch_assoc($result)){
  $youtube_ids_out[] = $row['youtube_id'] ;
  $wins_out[]        = $row['win'       ] ;
  $losses_out[]      = $row['lose'      ] ;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" media="all" href="style.css" />
<title>That Weird Part Of Youtube!</title>
<script src="functions.js"></script>
<script src="youtube_jsapi.js"></script>
</head>
<body onload="start()">
<script>
var id_left    = '<?php echo $youtube_ids_out[0] ; ?>' ;
var id_right   = '<?php echo $youtube_ids_out[1] ; ?>' ;
var win_left   = <?php echo $wins_out[0] ; ?> ;
var win_right  = <?php echo $wins_out[1] ; ?> ;
var lose_left  = <?php echo $losses_out[0] ; ?> ;
var lose_right = <?php echo $losses_out[1] ; ?> ;
</script>
<div id="maincontainer">

<div id="topsection">
  <h1>That Weird Part Of Youtube!</h1>
</div>

<div id="contentwrapper">
  <div id="div_simply_choose">Simply choose which videos is weirder:</div>
  <div class="table">
    <div class="tab_row">
      <div id="div_left">
        <div class="innertube center">
          <object width="350" height="195" id="left_player"  type="application/x-shockwave-flash" data="https://www.youtube.com/v/<?php echo $youtube_ids_out[0] ; ?>?version=3&amp;enablejsapi=1">
            <param name="movie" id="youtube_object_movie" value=""/>
            <param name="allowScriptAccess" value="always"/>
            <param name="allowFullScreen" value="true" />
          </object>
          <div class="score">
            <span id="span_left_win"  class="score"></span>
            <span id="span_left_lose" class="score"></span>
          </div>
          <input id="input_choose_left" class="button neutral" type="submit" value="This video is weirder!"/>
        </div>
      </div>
      <div id="div_right">
        <div class="innertube center">
          <object width="350" height="195" id="right_player" type="application/x-shockwave-flash" data="https://www.youtube.com/v/<?php echo $youtube_ids_out[1] ; ?>?version=3&amp;enablejsapi=1">
            <param name="movie" id="youtube_object_movie" value=""/>
            <param name="allowScriptAccess" value="always"/>
            <param name="allowFullScreen" value="true" />
          </object>
          <div class="score">
            <span id="span_right_win"  class="score"></span>
            <span id="span_right_lose" class="score"></span>
          </div>
          <input id="input_choose_right" class="button neutral" type="submit" value="This video is weirder!"/>
        </div>
      </div>
    </div>
  </div>
  <div id="div_suggest">
    <h2>Suggest a video!</h2>
    <div id="div_suggest_inner">
      URL: <input id="input_suggest" name="youtube_id" type="text" value=""/>
      <input id="submit_suggest" class="neutral" type="submit" value="Suggest video"/>
    </div>
  </div>
  <div id="div_status">&nbsp;</div>
</div>

<div id="image_preview"><img src="background.jpg"/></div>

<div id="footer">&copy; Aidan Randle-Conde 2014</div>

</div>
</body>
</html>
