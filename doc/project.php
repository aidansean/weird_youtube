<?php
include_once($_SERVER['FILE_PREFIX']."/project_list/project_object.php") ;
$github_uri   = "https://github.com/aidansean/weird_youtube" ;
$blogpost_uri = "http://aidansean.com/projects/?tag=weird_youtube" ;
$project = new project_object("weird_youtube", "That Weird Part of YouTube", "https://github.com/aidansean/weird_youtube", "http://aidansean.com/projects/?tag=weird_youtube", "weird_youtube/images/project.jpg", "weird_youtube/images/project_bw.jpg", "One of the most fruitful memes on the internet is \"That wierd part of YouTube\".  I saw an opportunity to create a service to find the weirdest videos on YouTube, and I made this webpage.", "Toys", "canvas,CSS,HTML,JavaScript,YouTube") ;
?>