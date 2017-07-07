<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.patricelaurent.net/
 * @since      1.0.0
 *
 * @package    Tab_My_Content
 * @subpackage Tab_My_Content/public/partials
 */
$_tabmc_title_first_tab = get_post_meta(get_the_ID(), '_tabmc_title_first_tab',true);
$initialTab = !empty($_tabmc_title_first_tab) ? $_tabmc_title_first_tab : __('Presentation', 'tab-my-content');
$tabs = have_tabmc(get_the_ID());
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="tabsmc_selector">
    <ul>
        <li><a href="#tabs-main"><?php echo $initialTab ?></a></li>
        <?php foreach ($tabs as $tab) { ?>
        <li><a href="#tabs-<?php echo $tab->ID ?>"><?php echo get_the_title($tab->ID) ?></a></li>
        <?php } ?>
    </ul>
    <div id="tabs-main">
        <?php echo $content ?>
    </div>
	<?php foreach ($tabs as $tab) { ?>
        <div id="tabs-<?php echo $tab->ID ?>"><?php echo wpautop( $tab->post_content ) ?></div>
	<?php } ?>
</div>