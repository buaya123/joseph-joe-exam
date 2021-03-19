<?php

$api    = 'https://www.googleapis.com/youtube/v3/channels';
$part = 'contentDetails';
$forUsername= 'NBA';
$key= 'AIzaSyDw_QK9I3ZwIx1H0pny4WwHwZ33ejAxY34';

$getChannel = $api.'?part='.$part.'&forUsername='.$forUsername.'&key='.$key;
$channel = json_decode(file_get_contents($getChannel));
//echo '<pre>';
//print_r($channel);
//echo $getChannel;


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


$vidlInfo = json_decode(file_get_contents($getVids));

foreach($vidlInfo->items as $item){
  //$channelId= $item->snippet->relatedPlaylists->uploads;
//  $channelName
  $videoLink = 'https://www.youtube.com/watch?v='.$item->snippet->resourceId->videoId;
  $title = $item->snippet->title;
  $description = $item->snippet->description;
  $thumbnail = $item->snippet->thumbnails->medium->url;

}

$ret = json_encode(array_merge_recursive(json_decode(file_get_contents($getVids), true),json_decode(file_get_contents($getChannelInfo), true)),JSON_PRETTY_PRINT);
//echo '<pre>';
echo "<pre>" . $ret . "</pre>";
?>