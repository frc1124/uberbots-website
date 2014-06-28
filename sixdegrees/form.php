<?
//the sniffing function
function sniffTeam($refTeam,$steps,$win,$el,$year){
	global $teams,$from,$matchid,$flag,$endTeam,$found,$q,$center;
	//red alliance (bang pause, bang pause, bang, bang, band)
	$query = mysql_query("SELECT `red1`,`red2`,`red3`,`matchid` FROM `matches` WHERE (`red1`='$refTeam' OR `red2`='$refTeam' OR `red3`='$refTeam')".(isset($_GET["winning"])?" AND `redscore` > `bluescore`":"").";");
	$q++;
	while($row = mysql_fetch_row($query)){
		for($i=0;$i<3;$i++){
			if($row[$i]!=$refTeam&&(!isset($teams[$row[$i]]))&&$row[$i]!=0){
				$center[$steps+1]++;
				$teams[$row[$i]]=$steps+1;
				$from[$row[$i]]=$refTeam;
				$matchid[$row[$i]]=$row[3];
				$flag[$row[$i]] = true;
				if($row[$i]==$endTeam){
					$found = true;
					return true;
					}
			}
		}
	}
	//blue alliance (bang pause, bang pause, bang, bang, band)
	$query = mysql_query("SELECT `blue1`,`blue2`,`blue3`,`matchid` FROM `matches` WHERE (`blue1`='$refTeam' OR `blue2`='$refTeam' OR `blue3`='$refTeam')".(isset($_GET["winning"])?" AND `redscore` < `bluescore`":"").";");
	$q++;
	while($row = mysql_fetch_row($query)){
		for($i=0;$i<3;$i++){
			if($row[$i]!=$refTeam&&(!isset($teams[$row[$i]]))&&$row[$i]!=0){
				$center[$steps+1]++;
				$teams[$row[$i]]=$steps+1;
				$from[$row[$i]]=$refTeam;
				$matchid[$row[$i]]=$row[3];
				$flag[$row[$i]] = true;
				if($row[$i]==$endTeam){
					$found = true;
					return true;
					}
			}
		}
	}
}

$q= 0;

$con = mysql_connect("localhost","uberbots_degrees","baconkevin");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("uberbots_sixdegrees", $con);

$q = 0;

//get team #s
if(isset($_GET['start']) && isset($_GET['end'])){
	if(is_numeric($_GET["start"]) && is_numeric($_GET["end"])){
		$query = mysql_query("SELECT * FROM `teams` WHERE `teamnumber` = '".$_GET["start"]."' OR `teamnumber` = '".$_GET["end"]."';") or die(mysql_error());
		if(mysql_num_rows($query)==2){
			$startTeam = $_GET["start"];
			$endTeam = $_GET["end"];
		}
		else
			$message = "One or more of those teams don't exist.";
	}
	else{
		$message = "You did not enter valid numeric team numbers";
	}
}

//check other options
$winning = $_GET['winning']=='on'?true:false;
$elim = $_GET['elim']=='on'?true:false;
if($_GET['year']=='all')
	$year = 0;
else
	$year = $_GET['year'];


//# of steps each team is away
$teams = array();
//team from which last link is derived
$from = array();
//match from which last link was derived
$matchid = array();
//flags if sniffTeam function has not been run on a discovered team yet
$flag = array();

//how good of a "center" is a team?
$center = array();

//has the end team been found yet?
$found = false;

//team always has its own # of 0
$teams[$startTeam]=0;
$center[0]=1;

//what starts it all
sniffTeam($startTeam,0,$winning,$elim,$year);

$flaggeds = 1;

//continue until there are no discovered teams left unsniffed
while($flaggeds>0&&!$found){
	$flaggeds = 0;
	foreach($flag as $index=>$value){
		if($value&&(isset($value))){
			sniffTeam($index,$teams[$index]);
			unset($flag[$index]);
			$flaggeds++;
		}
			if($found)
			break;
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Six Degrees of FIRST</title>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div style="top:20%;text-align:center;position:absolute;width:100%;background-color:rgba(0,0,0,.5);">
<img src="images/logo.png"  alt="Six Degrees of FIRST"/>
<p>Find the shortest relationship between two FRC teams by linking them through alliances.</p>

<?
if(!isset($teams[$endTeam])){
	$message = "<p>Team $endTeam has a Team $startTeam number of infinity; there is no relationship between the two teams.</p>";
	}
if(!isset($message) && isset($_GET['start']) && isset($_GET['end'])){
	echo "<p>Team $endTeam has a Team $startTeam number of ".$teams[$endTeam].".</p>";
	
	$marker = $endTeam;
	for($i=0;$i<=$teams[$endTeam];$i++){
		
		$query  = mysql_query("SELECT `name`, `informalname` FROM `teams` WHERE `teamnumber` = '$marker'");
		$row = mysql_fetch_array($query);
		$count = $teams[$endTeam] - $i;
		
		echo "<p>$count. <a href=\"http://www.thebluealliance.net/tbatv/team/".$marker."\">FRC Team #$marker".($row["informalname"]==""?($row["name"]==""?"":", ".$row["name"]):", ".$row["informalname"])."</a></p>";
		
		
		if($i!=$teams[$endTeam]){
		  $query = mysql_query("SELECT `events`.`name` as `eventTitle`, `events`.`year` as `year`, `matches`.`matchname` as `matchTitle`, `matches`.`matchnumber` as `number`, `events`.`eventshort` as `short` FROM `matches` LEFT JOIN `events` ON `matches`.`event` = `events`.`eventid` WHERE `matchid` = '".$matchid[$marker]."'") or die(mysql_error());
		  
		  $row = mysql_fetch_array($query);
		  
		  echo "<p><a href=\"http://thebluealliance.net/tbatv/event/".$row["year"].$row["short"]."\">".(($row["matchTitle"]=="")?"Qualification #".$row["number"]:$row["matchTitle"])." at ".$row["year"]." ".$row["eventTitle"]."</a></p>";
		  
		  $marker = $from[$marker];
		}}
}
else{
	echo "<p>".$message."</p>";
	}
?>

<form method="get" action="">
Enter two FRC team numbers:<br />
<input type="text" name="start" class="coolBox" size="4" value="<? echo isset($_GET['start'])?$_GET['start']:"1124"; ?>"/> &nbsp; &nbsp; &nbsp; <input type="text" name="end" class="coolBox" size="4" value="<? echo isset($_GET['start'])?$_GET['end']:""; ?>"/>
<input type="submit" value="Go" class="coolBox"/>
<div style="color:#66F;border:#006 1px solid;">
<p>Options:</p>
<input type="checkbox" name="winning" /> Winning Matches Only<br/>
<input type="checkbox" name="elim" /> Elimination Matches <br/>

<?
echo '<select name="year">';
$q = mysql_query("SELECT DISTINCT year FROM events ORDER BY year ASC");
echo "<option value='all' SELECTED>All Years</option>";
while($row = mysql_fetch_array($q)){
	echo "<option value='".$row['year']."'>".$row['year']."</option>";
}
echo "</select>";
?>

</div>
</form>
</div>
<div style="position:fixed;bottom:0;text-align: center;width:100%;text-decoration:none;">
<a href="about.php" class="underline">About</a> | <a href="http://uberbots.org" class="underline">The UberBots</a> | Thanks to <a href="http://www.thebluealliance.net/" class="underline">The Blue Alliance</a> 
</div>
</body>

</html>
<?
mysql_close($con);
?>