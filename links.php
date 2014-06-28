<?
//finds a trail of links between two wikipedia pages

//start time
$startTime = microtime(1);

//maximum steps
$maxSteps = 4;

$start = str_replace(" ","+",$_GET["start"]);
$end = $_GET["end"];

$found = false;

function searchPage($page,$trail){
	global $maxSteps,$start,$end,$found;
	$cu = curl_init();
	curl_setopt( $cu, CURLOPT_URL ,"http://en.wikipedia.org/w/index.php?title=$page&printable=yes");
	curl_setopt( $cu, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $cu, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
	$list = curl_exec($cu);
	curl_close($cu);
	
	$list_start = strpos($list,'div id="siteSub">From Wikipedia, the free encyclopedia</div>')+strlen('div id="siteSub">From Wikipedia, the free encyclopedia</div>');
	$list_end = strpos($list,'<div class="visualClear"></div>');
	$list = substr($list,$list_start,$list_end);
	
	preg_match_all("%href=\"/wiki/([^\"]+)\"%",$list,$list);
	
	$trail[]=$page;
	
	foreach($list[1] as $item){
		if(!$found){
			if(strtolower($item)==strtolower($end)){
				print_r($trail);
				$found = true;
				}
			
			if(sizeof($trail)<$maxSteps)
				searchPage($item,$trail);
		}}
	
	return false;
	}

searchPage($start,array());

if(!$found)
echo("Not found in less than $maxSteps steps.");

$endTime = microtime(1);

echo "<p>".($endTime-$startTime)."seconds";
?>