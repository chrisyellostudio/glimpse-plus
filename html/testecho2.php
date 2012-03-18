<?php

echo '<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Google Product Search</title>
	<meta name="description" content="Test Echo">
	<meta name="author" content="SitePoint">
	<link rel="stylesheet" href="echostyles.css">
	<!--[if lt IE 9]>  
	<script src="<a href="http://html5shiv.googlecode.com/svn/trunk/html5.js"></a>"></script>  
	<![endif]--> 
</head>
<body>
	<div class="ContentWrapper" class="clearfix">
		<div class="Content">
	';	

// Useful to check if the variable have some value...specially for GET POST variables 
//function isset_or(&$check, $alternate = NULL) 
//{ 
//    return (isset($check)) ? (empty($check) ? $alternate : $check) : $alternate; 
//} 
	
$maxresults = isset($_POST['maxresults']);
$startIndexURLString = '&startIndex=26';
$maxresultsURLString = '&maxResults=25';

$APIkey = 'AIzaSyAgkxANYayzTupDm-0JH-e7hgKljqyrx7E';
$url = 'https://www.googleapis.com/shopping/search/v1/public/products?key=AIzaSyAgkxANYayzTupDm-0JH-e7hgKljqyrx7E&country='. $_POST['country'] .'&q='. urlencode($_POST['searchquery']) .'&alt=json';
// use fopen and fread to pull Google's search results

$handle = fopen($url, 'rb');
$body = '';
while (!feof($handle)) {
$body .= fread($handle, 131072);
}
fclose($handle);

// now $body is the JSON encoded results. We need to decode them.

$results_object = json_decode($body);

	echo '<span class="right"><span class="redcount">'.$results_object->currentItemCount.'</span><span class="grey"> out of </span><span class="redcount">'.$results_object->totalItems.' </span><span class="grey"> items.</span></span>';
	echo '<br/>';
	
	$itemsperpage = $results_object->itemsPerPage;
	$startitemindex = $results_object->startIndex;
	$nextpagelink = $results_object->nextLink;
	$currentpage = $results_object->selfLink;
	
	$firstpage = 'https://www.googleapis.com/shopping/search/v1/public/products?country=GB&q='. urlencode($_POST['searchquery']) .'&alt=json&startIndex=1&maxResults=25"';
	$lastpage = 'https://www.googleapis.com/shopping/search/v1/public/products?country=GB&q='. urlencode($_POST['searchquery']) .'&alt=json&startIndex='.($itemsperpage - $results_object->totalItems).'&maxResults=25"';
	$previouspage = '';
	$nextpage = $nextpagelink;
	 
//	echo '<a href="'.$results_object->nextLink.'">nextLink</a>';
	
//	echo '<a href="'.$firstpage.'">  <<  </a><a href="'.$previouspage.'">  <  </a><a href="'.$currentpage.'">  current  </a><a href="'.$nextpage.'">  >  </a><a href="'.$lastpage.'">  >> </a>';

	foreach($results_object->items as $result){
		echo '<div class="Item">';
			if(count($result->product->images) > 1){
				echo '<img src="' .$res->link. ' "height="100" width="100"/>';
			}
			else{
				foreach($result->product->images as $res){
					echo '<img src="' .$res->link. ' "height="100" width="100"/>';
				}
			}
		echo '<h3><a target="_blank" href="'.$result->product->link.'">'.$result->product->title.'</a></h3>';
		echo '<p>'.$result->product->description.'</p>';
		echo '</div>';
	}
echo '
	</div>
</body>
</html>';

