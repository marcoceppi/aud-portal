<?php

$more = true;
$page = 0;
$days = array();
$tags = array();
$total = 0;
$tagged = 'application-development';
$fromdate = strtotime('2012-04-01');
$todate = strtotime('2012-07-01');

require_once('config.inc');

while($more)
{
	$page++;
	$query = 'http://api.stackexchange.com/2.0/questions?pagesize=99&fromdate=' . $fromdate . '&todate=' . $todate . '&order=asc&sort=creation&tagged=' . $tagged . '&site=askubuntu&key=' . $key . '&page=' . $page;

	$questions_compressed = file_get_contents($query);
	$questions_raw = gzinflate(substr($questions_compressed, 10, -8));
	$questions_decoded = json_decode($questions_raw, true);

	$questions = $questions_decoded['items'];
	$more = $questions_decoded['has_more'];
	$backoff = (array_key_exists('backoff', $questions_decoded)) ? $questions_decoded['backoff'] : FALSE;

	foreach( $questions as $question )
	{
		$date = date('Y-m-d', $question['creation_date']);
		if( !array_key_exists($date, $days) )
		{
			$days[$date] = 0;
		}

		$days[$date]++;
		foreach( $question['tags'] as $tag )
		{
			if( !array_key_exists($tag, $tags) )
			{
				$tags[$tag] = 1;
			}
			else
			{
				$tags[$tag]++;
			}
		}
		$total++;
	}

	if( $backoff )
	{
		sleep($backoff+1);
	}
}
arsort($tags);
unset($tags[$tagged]);
?>
<DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart", "table"]});
      google.setOnLoadCallback(drawChart);
      function drawChart()
      {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'Questions'],
<?php
foreach($days as $day => $qtotal)
{
	echo "['" . $day . "', " . $qtotal . "],";
}
?>
        ]);

        var options = {
          title: 'Questions from DATE DUDE',
          hAxis: {title: 'Day', titleTextStyle: {color: 'blue'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        var table = new google.visualization.Table(document.getElementById('table_div'));
        chart.draw(data, options);
        table.draw(data, {showRowNumber: false});
      }
</script>
</head>
<body>
<div id="total">Total Questions: <?php echo $total; ?></div>
<div id="chart_div" style="width: 900px; height: 500px;"></div>
<div id="table_div" style="width: 200px;"></div>
</body>
</html>
