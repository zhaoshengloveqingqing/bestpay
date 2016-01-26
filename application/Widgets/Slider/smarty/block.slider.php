<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

\Clips\require_widget_smarty_plugin('html', 'div');

function smarty_block_slider($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}
	
	$default = array(
		'class' => 'slider'
	);

	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $content);
}