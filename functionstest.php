<?php

include 'APIFunctions.php';
include 'SearchResults.php';

$s = new APIFunctions();
//$p = new SearchResults($s->parseJSONObject($s->fetchJSONObject($s->buildAPIURL('pepsi'))));


$a = $s->parseCacheHeader($url);
