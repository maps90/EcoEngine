<?php

class EcoEngineActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		// ACL: set ACOs with permissions
		$controller->Croogo->addAco('ecoEngine/Settings/admin_edit');
                $controller->Setting->write('EcoEngine.eefile',  APP . 'View' . DS . 'Themed' . DS . '{theme}' . DS . 'webroot' . DS . 'EcoEngine.json', array('description' => 'Configuration file for the template', 'editable' => 1));
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		// ACL: remove ACOs with permissions
		$controller->Croogo->removeAco('ecoEngine'); 
                $controller->Setting->deleteKey('EcoEngine.eefile');
	}
}
