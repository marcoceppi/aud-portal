{include file="_header.tpl" highlight=$CONTROLLER}
<div class="span12">
	<div class="row">
		<div class="span12">
			<div class="well">
				<form>
					<input type="text" class="span4"> <input type="date"> <input type="date">
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<h2 class="inline"><em>{$environment}</em> environment <a href="{$CONTROLLER}/bootstrap/{$environment}" rel="tooltip" data-original-title="Bootstrap"><i class="icon-large icon-play-circle"></i></a>&nbsp;<a href="{$CONTROLLER}/edit/{$environment}" rel="tooltip" data-original-title="Edit"><i class="icon-large icon-pencil"></i></a>&nbsp;<a href="{$CONTROLLER}/delete/{$environment}" rel="tooltip" data-original-title="Remove from Amulet"><i class="icon-large icon-remove"></i></a></h2> 
		</div>
	</div>
</div><!--/span-->
{include file="_footer.tpl"}
