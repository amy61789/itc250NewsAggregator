<?php
//feed.php
//our simplest example of consuming an RSS feed
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
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
           
	   }
}


//start of Session---------------------------------------------------
 if(!isset($_SESSION)){session_start();}

    //2) store Session in an array
    if(!isset($_SESSION['Session']))
    {//1) if session var does not exist, create it!
        $_SESSION['Session'] = array();
    }
date_default_timezone_set('America/Los_Angeles');
$time = date("m/d/y h:i:sa");

$_SESSION['Session'][] = new Session($response, $time);


//if there is no session time set, set it. 
if (array_key_exists($request,$_SESSION['Session']) == FALSE
    || strtotime($time) - strtotime($_SESSION['Session'][$request][1]) >= 600)#10 minutes
{
    //$response = file_get_contents($request);
    $_SESSION['Session'][$request] = array($response, $time); 
}

/*else if(isset($_POST['clearFeed']))
{
    echo "<h4>reloaded after clearing cache</h4>";
    
}else if (isset($_POST['clearAll'])) {
    echo "<h4>All Feeds are cleared</h4>";
    
}
*/
echo '<h2>Feeds refreshed every 10 minutes. Last refreshed at: ' .  $_SESSION['Session'][$request][1] . '</h2>';

//end of Session---------------------------------------------------


//Session class-----------------------------------
class Session 
{
    public $url = '';
    public $session_time = '';
    
    function __construct($url, $session_time)
    {
        $this->url = $url;
        $this->session_time = $session_time;
    }
}

//End of session class-----------------------------------------------


//Clearing cache--------------------------------
echo '<form method="post"><input type="submit" name="clearFeed" value="clear feed">
<input type="submit" name="clearAll" value="clear all"></form>';


if (isset($_POST['clearFeed']) && ($_POST['clearFeed'] == "clear feed")) {
    ClearFeed($request);
}else if (isset($_POST['clearAll']) && ($_POST['clearAll'] == "clear all")){
    ClearAll(); 
}

function ClearFeed($request) {
    unset($_SESSION['Session'][$request]);
    echo '<h4>Feed is cleared.</4>';
}
function ClearAll() {
    unset($_SESSION['Session']);
    echo '<h4>All Feeds are cleared.</4>';
    echo ' ';
}


if(isset($_SESSION['Session'])){
    echo '<p>This array is just to make sure if feed is cleared.</p>
         <pre>';
    print_r(array_keys($_SESSION['Session']));
    echo '</pre>';
}
else {
    echo "Session is empty";
}

//End of clearing cache--------------------------------


//------------------------------------------------------- 
@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	#overwrite PageTitle with Muffin info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
	
}




get_footer(); #defaults to theme header or footer_inc.php
?>