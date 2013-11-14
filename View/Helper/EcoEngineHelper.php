<?php

App::uses('AppHelper', 'View/Helper');

class EcoEngineHelper extends AppHelper
{

    function element($velem = '', $theme)
    {
        $paths2elements = array(
                'theme' => APP . 'View' . DS . 'Themed' . DS . $theme . DS . 'Elements' . DS,
                'plugin' => APP . 'Plugin' . DS . 'EcoEngine' . DS . 'View' . DS . 'Elements' . DS
            );
        $elementExt = '.ctp';

        $elementFallback = array(
            $velem, 'input'
        );

        foreach($paths2elements as $key => $path) {
            foreach($elementFallback as $element) {
                if(is_readable($path . $element . $elementExt)) {
                    if ($key == 'theme') {
                        $key = $$key;
                    } else {
                        $key = null;
                    }
                    return array('element' => $element, 'theme' => $key);
                }
            }
        }
        return false;
    }

}
