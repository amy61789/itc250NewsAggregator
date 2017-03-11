<?php
/**
 * demo_view.php along with demo_list.php provides a sample web application
 * 
 * @package nmListView
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.10 2012/02/28
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_list.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails

}else{
	myRedirect("category_view.php");
}

//sql statement to select individual item
$sql = "select FeedID,FeedName,Description,URL from NA_Feed where CategoryID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!
   
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;	
        echo '<h3 align="center"><?=News Feeds;?></h3>';
	   while ($row = mysqli_fetch_assoc($result))
	   {
        echo '<div align="center"><a href="feed.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['FeedName']) . '</a><br/>';
        echo '<tr><td>' . $row['Description'] . '</td></tr><br> ';
//	echo '<tr><td>URL: <br>' . $row['URL'] . '</td></tr> ';
	   }
}

@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	#overwrite PageTitle with Muffin info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
	
}
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/
# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>


<?php
if($foundRecord)
{#records exist - show muffin!
?>
	
<?
}else{//no such muffin!
    echo '<div align="center">What! No such feed? There must be a mistake!!</div>';
    
    echo '<div align="center"><a href="' . VIRTUAL_PATH . '/index.php">Another Muffin?</a></div>';
}
echo '<p><a href="../index.php">Go Back</a></p>';
get_footer(); #defaults to theme footer or footer_inc.php
?>