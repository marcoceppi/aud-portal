<!DOCTYPE html>
<html lang="en">
<head>
	<base href="{$BASE_URL}" />
	<meta charset="utf-8">
	<title>Portal - {$TITLE}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Portal">
	<link href="assets/css/bootstrap.united.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap.icon-large.min.css" rel="stylesheet">
	<link href="assets/css/site.css" rel="stylesheet">
	<link href="assets/css/datepicker.css" rel="stylesheet">
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- 
	<link rel="shortcut icon" href="/assets/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
	-->
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#">Data Portal</a>
				<div class="btn-group pull-right">
					<!-- 
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i> {$USERNAME} <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Settings</a></li>
						<li class="divider"></li>
						<li><a href="#">Log Out</a></li>
					</ul>
					-->
				</div>
				<div class="nav-collapse">
					<ul class="nav">
						<li {if $highlight eq 'dashboard'}class="active"{/if}><a href="dashboard">Dashboard</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<div class="container">
		{if !empty($ALERTS)}
		<div class="alert-container">
			{foreach $ALERTS as $alert}
				{include file="_alert.tpl" TYPE=$alert['type'] HEADING=$alert['heading'] MESSAGE=$alert['message']}
			{/foreach}
		</div>
		{/if}
		<div class="row">
