<strong class="tabmc_title"><span><?php _e('Current Tab(s) linked to it', 'tab-my-content') ?></span></strong>
<ol id="tabmc_sortable">
	<?php foreach ($tabMC as $tab){
		$menu_order = get_post_field( 'menu_order', $tab->ID);
		?>
	<li class="ui-state-default tabmc-listing" id="tabmc-<?php echo $tab->ID ?>" data-tab-id="<?php echo $tab->ID ?>">
		<span class="dashicons dashicons-move mover"></span>&nbsp;<?php echo get_the_title($tab->ID) ?>
		<a href="<?php echo admin_url('post.php?post='.$tab->ID.'&action=edit&') ?>"><span class="dashicons dashicons-edit"></span></a>
	</li>
<?php } ?>
</ol>
