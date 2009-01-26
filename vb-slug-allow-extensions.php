<?php
/*
Plugin Name: VB`s Slug With extensions
Plugin URI: http://vladbabii.com/experimente/vb-slug-allow-extensions/
Description: Allow extensions in slugs
Version: 1
Author: Vlad babii
Author URI: http://www.vladbabii.com
Tags: slug, filter, allow extension
*/

function vbslugallowextensions_filter($slug)
{
	echo '<!--slug:: '.$slug.'-->'."\n";
	static $allow;
	if(!isset($allow) || !is_array($allow))
	{
		/** EDIT NEXT LINE **/
		$allow=array('html','htm','asp','aspx','jsp');
	}
	if(strlen($slug)>0 && strstr('.',$slug)!==false)
	{
		$slug=explode('.',$slug);
		if(in_array($slug[count($slug)-1],$allow))
		{
			$extension=$slug[count($slug)-1];
			unset($slug[count($slug)-1]);
			$slug=sanitize_title_with_dashes(implode('.',$slug)).'.'.$extension;
			echo '<!--slug:: dotted: '.$slug.'-->'."\n";
			return $slug;
		} 
	} else {
		$slug=sanitize_title_with_dashes($slug);
		echo '<!--slug:: normal slug: '.$slug.'-->'."\n";
		return $slug;
	}		
}

remove_filter('sanitize_title', 'sanitize_title_with_dashes');
add_filter('sanitize_title','vbslugallowextensions_filter');
?>