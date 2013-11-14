<?php
App::uses('Component', 'Controller');

class EcoEngineComponent extends Component
{

    public $EcoEngineFile = '';
    public $Setting;
    public $settingsPrefix = 'EcoEngine';

    public function initialize(Controller &$Controller)
    {
        // cambiar esto al modelo de settings, porque esto se ondea
        $this->Setting = ClassRegistry::init('Settings.Setting');
        $theme = $this->oneValue('Site.theme');
        $engineInstalled = false;
        $settings = array();
        $eefile = '';
        $support = false;
        $oneValue = array('value');
        $eefile = $this->oneValue('EcoEngine.eefile', $oneValue);
        $eefile = str_replace('{theme}', $theme, $eefile);
        if (is_readable($eefile)) {
            $support = true;
            $engineInstalled = $this->oneValue($this->settingsPrefix . '.' . $theme . '.EEInstalled');
            if ($engineInstalled != null && $engineInstalled != false) {
                $engineInstlled = true;
                $settings = $this->formatSettings(
                        $this->Setting->find('all', array(
                            'fields' => array('id', 'key', 'value'),
                            'conditions' => array(
                                'Setting.key LIKE' => $this->settingsPrefix . '.' . $theme . '.%',
                                'Setting.key NOT LIKE' => $this->settingsPrefix . '.' . $theme . '.%.assembly'
                            )
                        )), $this->settingsPrefix . '.' . $theme . '.');
            }

            // if EcoEngine support is detected but not installed, show it
            //if ($support && is_null($engineInstalled)) {
            //$Controller->Session->setFlash('EcoEngine support detected, but not installed. Go to Settings/EcoEngine to install it.');
            //}
        }
        $retArray = array(
            'EcoEngine' => array(
                'theme' => $theme ,
                'support' => $support,
                'installed' => $engineInstalled,
                'file' => $eefile,
            ),
            'Settings' => $settings
        );
        $Controller->set('theme', $retArray);
    }

    public function oneValue($key)
    {
        $ret = $this->Setting->findByKey($key, array('value'));
        if (key_exists('Setting', $ret)) {
            if (key_exists('value', $ret['Setting'])) {
                return $ret['Setting']['value'];
            }
        }
        return $ret;
    }

    public function formatSettings($settings, $strip = '')
    {
        $retArray = array();
        foreach ($settings as $key => $setting) {
            $retArray[str_replace($strip, '', $setting['Setting']['key'])] = $setting['Setting']['value'];
        }
        unset($retArray['EEInstalled']);
        return $retArray;
    }

    public function getFields($jsonArray = array())
    {
        $retArray = array();
        foreach ($jsonArray as $keyfs => $fieldset) {
            foreach ($fieldset as $keyf => $field) {
                $retArray[] = array($keyfs . '.' . $keyf, json_encode($field), $field['cakeField']['value']);
            }
        }
        return $retArray;
    }

}
