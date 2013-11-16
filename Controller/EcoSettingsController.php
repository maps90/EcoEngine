<?php

App::uses('EcoEngineAppController', 'EcoEngine.Controller');

class EcoSettingsController extends EcoEngineAppController
{

    public $settingsPrefix = '';

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->settingsPrefix = $this->EcoEngine->settingsPrefix;
        $this->Security->unlockedActions += array('admin_edit', 'admin_attachments');
    }

    public function admin_edit()
    {
        $Setting = ClassRegistry::init('Settings.Setting');
        if ($this->request->is('post')) {
            foreach ($this->request->data as $data) {
                $Setting->read(null, $data['id']);
                if (is_array($data['value'])) {
                    $data['value'] = key($data['value']);
                }
                $Setting->set('value', $data['value']);
                $Setting->save();
            }
        }
        $theme = Configure::read('Site.theme');

        $settings = $Setting->find('all', array(
            'fields' => array('id', 'key', 'value'),
            'conditions' => array(
                'Setting.key !=' => $this->settingsPrefix . '.' . $theme . '.EEInstalled',
                'Setting.key LIKE' => $this->settingsPrefix . '.' . $theme . '.%'
        )));
        $this->set('Settings', $settings);
    }

    public function admin_install()
    {
        
    }

    public function admin_attachments()
    {
        $this->layout = 'admin_popup';
        if ($this->request->is('post')) {
            $this->EcoSetting =  ClassRegistry::init('EcoEngine.EcoSetting');
            $attachments = $this->EcoSetting->uploadFiles($this->request->data['Setting']['Files']);
            $this->set('attachments', $attachments);
            $this->set('returnTo', $this->request->data['Setting']['returnTo']);
            $this->render('admin_return_attachments');
        }
        if($this->request->query['multi'] == "0") {
            $this->set('multi', false);
        } else {
            $this->set('multi', true);
        }
        $this->set('returnTo', $this->request->query['returnTo']);
        $this->set('title_for_layout', __d('croogo', 'Upload'));
    }

    public function admin_recover()
    {
        // Recover ALL values to database from settings.json file
        // oops
        // 
        //$Setting = ClassRegistry::init('Settings.Setting');
        //$eefile = APP . DS .'Config/settings.json';
        //if (is_readable($eefile)) {
        //    $settings = file_get_contents($eefile);
        //    $settings = json_decode($settings, true);
        //    foreach($settings as $prefix => $setting) {
        //        foreach($setting as $set => $value) {
        //            $this->Setting->write($prefix.'.'.$set, $value, array('description' => 'Recovered', 'editable' => 0));
        //        }
        //    }
        //}
    }

    public function admin_reset()
    {
        $theme = Configure::read('Site.theme');
        $Setting = ClassRegistry::init('Settings.Setting');
        $settings = $Setting->find('all', array(
            'fields' => array('id', 'key', 'value'),
            'conditions' => array(
                'Setting.key like' => $this->settingsPrefix . '.' . $theme . '.%',
        )));
        foreach ($settings as $setting) {
            $Setting->deleteKey($setting['Setting']['key']);
        }
        $this->redirect(array('action' => 'install'));
    }

    public function admin_installation()
    {
        $theme = Configure::read('Site.theme');
        $eefile = Configure::read('EcoEngine.eefile');
        $eefile = str_replace('{theme}', $theme, $eefile);
        if (is_readable($eefile)) {
            $engine = file_get_contents($eefile);
            $engine = json_decode($engine, true);
            $fields = $this->EcoEngine->getFields($engine);
            $this->Setting = ClassRegistry::init('Settings.Setting');
            foreach ($fields as $field) {
                $this->Setting->write($this->settingsPrefix . '.' . $theme . '.' . $field[0], $field[2], array('description' => 'Theme field', 'editable' => 0));
                $this->Setting->write($this->settingsPrefix . '.' . $theme . '.' . $field[0] . '.assembly', $field[1], array('description' => 'Theme field assembly', 'editable' => 0));
            }
            $this->Setting->write($this->settingsPrefix . '.' . $theme . '.EEInstalled', true, array('description' => 'EcoEngine installed for this theme', 'editable' => 0));
        } else {
            $this->Session->setFlash('Installation file is not readable');
        }
        $this->redirect(array('action' => 'install'));
    }

}
