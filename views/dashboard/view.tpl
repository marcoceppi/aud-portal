{include file="_header.tpl" highlight=$CONTROLLER}
<div class="span12">
	<div class="row">
		<div class="span12">
			<div class="well">
				<form class="form-inline" method="get">
					<div class="control-group">
						<label class="control-label" for="tagged">Tag:</label>
						<div class="controls">
							<input type="text" class="span5" name="tagged" id="tagged" value="{$tagged}">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="from">From:</label>
						<div class="control date" data-date-format="yyyy/mm/dd" >
							<input type="text" class="span2" data-date-format="yyyy/mm/dd" name="from" id="from" value="{$fromdate}">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="to">To:</label>
						<div class="controls date" data-date-format="yyyy/mm/dd" >
							<input type="text" class="span2" data-date-format="yyyy/mm/dd" name="to" id="to" value="{$todate}">
						</div>
					</div>
					<div class="control-group">
						<button type="submit" class="btn btn-primary">Graph it!</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span8">
			<div id="days" style="min-height: 400px;"></div>
		</div>
		<div class="span4">
			<div id="tags" style="min-height: 400px;"></div>
		</div>
	</div>
	<div class="row">
		<div class="offset2 span3">
			<div id="days_table"></div>
		</div>
		<div class="offset1 span4">
			<div id="tags_table"></div>
		</div>
	</div>
</div><!--/span-->
{include file="_footer.tpl"}
