var left_h2      = null ;
var right_h2     = null ;
var left_div     = null ;
var right_div    = null ;
var left_button  = null ;
var right_button = null ;
var xmlhttp_vote = null ; // Not sure this should be global
var xmlhttp_add  = null ; // Not sure this should be global
var left_player  = null ;
var right_player = null ;

function start(){
  left_h2      = Get('h2_left' ) ;
  right_h2     = Get('h2_right') ;
  left_div     = Get('div_left' ) ;
  right_div    = Get('div_right') ;
  left_button  = Get('input_choose_left' ) ;
  right_button = Get('input_choose_right') ;
  left_player  = Get('left_player' ) ;
  right_player = Get('right_player') ;
  
  left_button .addEventListener('mouseover', highlight_left ) ;
  right_button.addEventListener('mouseover', highlight_right) ;
  left_button .addEventListener('mouseout' , try_reset_highlight) ;
  right_button.addEventListener('mouseout' , try_reset_highlight) ;
  left_button .addEventListener('mousedown', submit_left ) ;
  right_button.addEventListener('mousedown', submit_right) ;
  Get('submit_suggest').addEventListener('mousedown', submit_add) ;
  document.addEventListener('keydown', keydown) ;
  
  window.setTimeout('change_videos()', 1000) ;
  Get('span_left_win'  ).innerHTML = '&#9650; ' + win_left   ;
  Get('span_right_win' ).innerHTML = '&#9650; ' + win_right  ;
  Get('span_left_lose' ).innerHTML = '&#9660; ' + lose_left  ;
  Get('span_right_lose').innerHTML = '&#9660; ' + lose_right ;
}

function keydown(evt){
  var keyDownID = window.event ? event.keyCode : (evt.keyCode != 0 ? evt.keyCode : evt.which) ;
  switch(keyDownID){
    case 13:
      evt.preventDefault() ;
      if(Get('input_suggest').value!='') submit_add() ;
      break ;
  }
}


function submit_left(){
  var winner = id_left  ;
  var loser  = id_right ;
  submit_vote(winner, loser) ;
}
function submit_right(){
  var winner = id_right ;
  var loser  = id_left  ;
  submit_vote(winner, loser) ;
}

function submit_vote(winner, loser){
  var uri = 'choose_videos.php?vote_up=' + winner + '&vote_down=' + loser + '&youtube_ids=' + id_left + ';' + id_right ;
  xmlhttp_vote = GetXmlHttpObject() ;
  xmlhttp_vote.onreadystatechange = update_videos_from_xmlhhtp ;
  xmlhttp_vote.open('GET', uri+'&sid=' + Math.random(),true) ;
  xmlhttp_vote.send(null) ;
}
function update_videos_from_xmlhhtp(){
  if(xmlhttp_vote.readyState==4){
    var ids    = xmlhttp_vote.responseText.split('%')[0].split(';') ;
    var scores = xmlhttp_vote.responseText.split('%')[1].split(',') ;
    Get('span_left_win'  ).innerHTML = '&#9650; ' + scores[0] ;
    Get('span_right_win' ).innerHTML = '&#9650; ' + scores[1] ;
    Get('span_left_lose' ).innerHTML = '&#9660; ' + scores[2] ;
    Get('span_right_lose').innerHTML = '&#9660; ' + scores[3] ;
    var success = true ;
    if(ids.length!=2) success = false ;
    if(ids[0].length!=11 || ids[1].length!=11) success = false ;
    if(!success){
      Get('div_status').innerHTML = 'Sorry, there was a server error.  Please refresh the page.' ;
      return ;
    }
    id_left  = ids[0] ;
    id_right = ids[1] ;
    change_videos() ;
  }
}
function change_videos(){
   left_player .cueVideoById(id_left ) ;
   right_player.cueVideoById(id_right) ;
   try_reset_highlight() ;
}

function submit_add(){
  var add_id = 'add_video.php?youtube_id=' + match_youtube(Get('input_suggest').value) ;
  xmlhttp_add = GetXmlHttpObject() ;
  xmlhttp_add.onreadystatechange = add_video_response_from_xmlhhtp ;
  xmlhttp_add.open('GET', add_id+'&sid=' + Math.random(),true) ;
  xmlhttp_add.send(null) ;
}
function add_video_response_from_xmlhhtp(){
  if(xmlhttp_add.readyState==4){
    Get('div_status').innerHTML = xmlhttp_add.responseText ;
    window.setTimeout('clear_div_status()', 2000) ;
    Get('input_suggest').value = '' ;
  }
}

function clear_div_status(){
  Get('div_status').innerHTML = '&nbsp;' ;
}

function highlight_left(){
  left_h2.className      = 'selected' ;
  right_h2.className     = 'selected' ;
  left_div.className     = 'selected' ;
  right_div.className    = 'rejected' ;
  left_button.className  = 'button selected' ;
  right_button.className = 'button rejected' ;
}
function highlight_right(){
  right_h2.className     = 'selected' ;
  left_h2.className      = 'selected' ;
  right_div.className    = 'selected' ;
  left_div.className     = 'rejected' ;
  right_button.className = 'button selected' ;
  left_button.className  = 'button rejected' ;
}
function try_reset_highlight(){
  right_h2.className     = '' ;
  left_h2.className      = '' ;
  right_div.className    = '' ;
  left_div.className     = '' ;
  left_button.className  = 'button neutral' ;
  right_button.className = 'button neutral' ;
}

function match_youtube(string){
  var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
  var match = string.match(regExp) ;
  if(match&&match[2].length==11){
    return match[2] ;
  }else{
    return -1 ;
  }
}

function GetXmlHttpObject(){
  if(window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
    return new XMLHttpRequest() ;
  }
  if(window.ActiveXObject){
    // code for IE6, IE5
    return new ActiveXObject("Microsoft.XMLHTTP") ;
  }
  return null ;
}

function Get(id){ return document.getElementById(id) ; }
