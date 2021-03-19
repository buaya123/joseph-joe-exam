
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "youtube_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$api    = 'https://www.googleapis.com/youtube/v3/channels';
$part = 'contentDetails';
$forUsername= 'NBA';
$key= 'AIzaSyDw_QK9I3ZwIx1H0pny4WwHwZ33ejAxY34';

$getChannel = $api.'?part='.$part.'&forUsername='.$forUsername.'&key='.$key;
$channel = json_decode(file_get_contents($getChannel));
//echo '<pre>';
//print_r($channel);
echo $getChannel;


foreach($channel->items as $item){
  $channel= $item->contentDetails->relatedPlaylists->uploads;
}




$api2 = 'https://www.googleapis.com/youtube/v3/playlistItems';
$part= 'snippet';
$maxResults= 100;
$playlistId= $channel;

$getVids = $api2.'?part='.$part.'&playlistId='.$playlistId.'&key='.$key.'&maxResults='.$maxResults;
//echo $getVids;

$getChannelInfo = $api.'?part='.$part.'&forUsername='.$forUsername.'&key='.$key;


$channelInfo = json_decode(file_get_contents($getChannelInfo));

foreach($channelInfo->items as $item){
  $channel_name = $item->snippet->title;
  $channel_description = $item->snippet->description;
  $channel_thumbnail = $item->snippet->thumbnails->medium->url;
}

$sql = "INSERT INTO youtube_channels (profile_picture,name, description) VALUES ('".$channel_thumbnail."','".$channel_name."','".$channel_description."')";
// echo "</br></br></br>";
// echo $channel_name;echo "</br></br></br>";
// echo $channel_description;echo "</br></br></br>";
// echo $channel_thumbnail;

mysqli_query($conn,$sql);

$vidlInfo = json_decode(file_get_contents($getVids));

foreach($vidlInfo->items as $item){
  //$channelId= $item->snippet->relatedPlaylists->uploads;
//  $channelName
  $videoLink = 'https://www.youtube.com/watch?v='.$item->snippet->resourceId->videoId;
  $title = $item->snippet->title;
  $description = $item->snippet->description;
  $thumbnail = $item->snippet->thumbnails->medium->url;

  $sql = "INSERT INTO youtube_channel_videos (video_link,title, description, thumbnail) VALUES ('".$videoLink."','".$title."','".$description."','".$thumbnail."')";

  mysqli_query($conn,$sql);
}




?>
