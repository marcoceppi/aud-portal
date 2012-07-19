{literal}
google.load("visualization", "1", {packages:["corechart", "table"]});
google.setOnLoadCallback(drawMeLikeYouOtherWhores);
function drawMeLikeYouOtherWhores()
{
	var daysData = google.visualization.arrayToDataTable(
	[
		['Day', 'Questions'],
		{/literal}
		{foreach $days as $day => $qtotal}
		['{$day}', {$qtotal}],
		{/foreach}
		{literal}
	]);

	var options =
	{
		{/literal}
		title: 'Questions from {$fromdate} to {$todate}',
		{literal}
		hAxis: {title: 'Day'}
	};

	var tagData = google.visualization.arrayToDataTable([
		['Tag', 'Relevance'],
		{/literal}
		{foreach $tags as $tag => $ttotal}
		['{$tag}', {$ttotal}],
		{/foreach}
		{literal}
	]);
	
	var allTagData = google.visualization.arrayToDataTable([
		['Tag', 'Times referenced'],
		{/literal}
		{foreach $all_tags as $tag => $ttotal}
		['{$tag}', {$ttotal}],
		{/foreach}
		{literal}
	]);

	var tagOptions = {
		title: 'Related Tags'
	};

	var tags = new google.visualization.PieChart(document.getElementById('tags'));
	var chart = new google.visualization.ColumnChart(document.getElementById('days'));
	var table = new google.visualization.Table(document.getElementById('days_table'));
	var tags_table = new google.visualization.Table(document.getElementById('tags_table'));
	chart.draw(daysData, options);
	table.draw(daysData, {showRowNumber: false});
	tags_table.draw(allTagData, {showRowNumber: false});
	tags.draw(tagData, tagOptions);
}
{/literal}
