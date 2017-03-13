# itc250NewsAggregator

 Include FeedCache.php in your script
 
 Then simply pass in the local file-name (that you want to save it as) and the remote feed:
 
   $feed_cache = new FeedCache('local_file.xml', 'http://example.com/feed.xml');
   $data = simplexml_load_string($feed_cache->get_data());
 You will also need to make sure you have a writable folder called "cache" in the root of your site.