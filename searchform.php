<form id="searchform" method="get" action="<?php echo home_url(); ?>/">
	<div>
		<input id="s" name="s" type="text" value="<?php echo esc_html($s, 1); ?>" tabindex="1" size="8" />
		<input id="searchsubmit" name="searchsubmit" type="submit" value="Find" tabindex="2" />
	</div>
</form> 