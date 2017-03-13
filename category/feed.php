<?php
//feed.php
//our simplest example of consuming an RSS feed
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
include '../FeedCache.php';
$feed_cache = new FeedCache('../xml/Microsoft_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Google_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Apple_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Recipes_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Chefs_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Restaurants_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Comedy_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Action_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

$feed_cache = new FeedCache('../xml/Sci-Fi_local_file.xml', 'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss');
$data = simplexml_load_string($feed_cache->get_data());

//sql statement to select individual item
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect("category_view.php");
}
$sql = "select FeedName, URL, CategoryID from NA_Feed where FeedID= " . $myID;

get_header(); #defaults to theme header or header_inc.phpΩ
$foundRecord = FALSE; # Will change to true, if record found!
   
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)    
{#records exist - process
	   $foundRecord = TRUE;	
    echo '<h3 align="center"><?=smartTitle();?></h3>';
	   while ($row = mysqli_fetch_assoc($result))
	   {    
      $request = $row['URL'];
      $response = file_get_contents($request);
      $xml = simplexml_load_string($response);
      print '<h1>' . $xml->channel->title . '</h1>';
      foreach($xml->channel->item as $story)
      {
        echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        echo '<p>' . $story->description . '</p><br /><br />';
      }
           
        
           
        //echo '<div align="center"><a href="category_view.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['FeedName']) . '</a><br/>';
        //echo '<tr><td>Description: ' . $row['Description'] . '</td></tr><br> ';
	//echo '<tr><td>URL: <br>' . $row['URL'] . '</td></tr> ';
	   }
}

@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	#overwrite PageTitle with Muffin info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
	
}




get_footer(); #defaults to theme header or footer_inc.php
?>