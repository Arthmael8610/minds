<?php

$limit = get_input("limit", 12);
$offset = get_input("offset", 0);
$username = get_input("username", elgg_get_logged_in_user_entity()->username);
$user = get_user_by_username($username);
$filter = get_input("filter", "all");

die(print_r($username,true));
$page_owner = get_user_by_username($username);
elgg_set_page_owner_guid($page_owner->getGUID());

if($filter == 'media')
$subtypes = 'kaltura_video';
elseif ($filter == 'images')
$subtypes = 'album';
elseif ($filter == 'files')
$subtypes = 'file';
else
$subtypes = array('kaltura_video', 'album', 'file');

$content = elgg_list_entities(	array(	'types' => 'object', 
										'subtypes' => $subtypes, 
										'limit' => $limit, 
										'offset' => $offset, 
										'owner_guid' => $user->guid,
										'full_view' => FALSE,
										'archive_view'=>TRUE
									));
$sidebar = elgg_view('archive/sidebar');
/*
		// Get categories, if they're installed
		global $CONFIG;
		$area3 = elgg_view('kaltura/categorylist',array('baseurl' => $CONFIG->wwwroot . 'search/?subtype=kaltura_video&tagtype=universal_categories&tag=','subtype' => 'kaltura_video'));
*/
elgg_register_menu_item('title', array('name'=>'upload', 'text'=>elgg_echo('upload'), 'href'=>'archive/upload','class'=>'elgg-button elgg-button-action'));
$vars['filter_context'] = 'mine';
$body = elgg_view_layout(	"gallery", array(
												'content' => $content, 
												'sidebar' => $sidebar, 
												'title' => elgg_echo('archive'),
												'filter_override' => elgg_view('page/layouts/content/archive_filter', $vars),
											));

	// Display page
echo elgg_view_page(elgg_echo('kalturavideo:label:adminvideos'),$body);

?>
