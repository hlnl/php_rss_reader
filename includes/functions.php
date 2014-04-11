<?php

function getFeed() {
$feed_url = array("http://www.giantitp.com/comics/oots.rss?format=xml", "http://feeds.reuters.com/news/artsculture?format=xml", "http://feeds.reuters.com/reuters/oddlyEnoughNews?format=xml", "http://feeds.reuters.com/reuters/scienceNews?format=xml", "http://feeds.reuters.com/reuters/smallBusinessNews?format=xml", "http://feeds.reuters.com/reuters/UShealthcareNews?format=xml", "http://feeds.reuters.com/reuters/technologysectorNews?format=xml", "http://feeds.reuters.com/reuters/telecomsectorNews?format=xml", "http://feeds.reuters.com/reuters/USVideoTopNews?format=xml", "http://feeds.reuters.com/news/hedgefunds?format=xml");
$connect_current = mysqli_connect("localhost","root","","rss_feeds_general");

foreach ($feed_url as $key=>$feed_url_extracted) {
    $xml = new SimpleXmlElement(file_get_contents($feed_url_extracted));
	$feed_analysis_depth = 40;
	echo "<h1>feed " . $key . ": " . $feed_url_extracted . "</h1>";
	for ($i=0; $i < $feed_analysis_depth; $i++) {
    	echo '<ul><font color="lightgray">feed entry ' . $i . '</font><ul><font color="green">link:</font> ' . $xml->channel->item[$i]->link . '<br><font color="green">domain:</font> ' . "--" . '<br><font color="green">description:</font> ' . $xml->channel->item[$i]->description . '<font color="green">pubDate:</font> ' . $xml->channel->item[$i]->pubDate . '<br><br>';
    	$parsed_url=parse_url($xml->channel->item[$i]->link);
	if (!mysqli_query($connect_current,"INSERT INTO articles VALUES (null,'" . addslashes($xml->channel->item[$i]->link) . "','" . $parsed_url['host'] . "','" . addslashes($xml->channel->item[$i]->description) . "','" . addslashes($xml->channel->item[$i]->pubDate) . "')"))
		{ die('<font color="red">MySQL error:</font> ' . mysqli_error($connect_current)); }
		echo "</ul></ul>";
    	}
	}
}
?>