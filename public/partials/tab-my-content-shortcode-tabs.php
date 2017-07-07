<div id="tabsmc_selector">
	<ul>
		<?php foreach ($tabs as $tab_id => $tab_title) { ?>
			<li><a href="#tabs-<?php echo $tab_id ?>"><?php echo $tab_title ?></a></li>
		<?php } ?>
	</ul>
	<?php foreach ($tabs_content as $tab_id => $tab_content) { ?>
		<div id="tabs-<?php echo $tab_id ?>"><?php echo wpautop( $tab_content ) ?></div>
	<?php } ?>
</div>