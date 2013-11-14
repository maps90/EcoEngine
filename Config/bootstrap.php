<?php

Croogo::hookRoutes('EcoEngine');
Croogo::hookComponent('*', 'EcoEngine.EcoEngine');
/**
 * Admin menu (navigation)
 */
CroogoNav::add('extensions.children.themes.children.ecoengine', array(
	'title' => 'Settings',
	'url' => array(
		'plugin' => 'EcoEngine',
		'controller' => 'Settings',
		'action' => 'edit',
		'admin' => true,
	),
));
CroogoNav::add('settings.children.ecoengine', array(
	'title' => 'EcoEngine',
	'url' => array(
		'plugin' => 'EcoEngine',
		'controller' => 'Settings',
		'action' => 'install',
		'admin' => true,
	),
));
