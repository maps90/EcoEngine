<?php

App::uses('AppModel', 'Model');

/**
 * Product Model
 *
 * @property ProductImage $ProductImage
 * @property ShippingClass $ShippingClass
 * @property Tax $Tax
 * @property ProductTerm $ProductTerm
 */
class EcoSetting extends AppModel
{

    public function uploadFiles($files)
    {
        App::uses('Attachment', 'FileManager.Model');
        $this->Attachment = new Attachment();
        $retArray = array();
        foreach ($files as $file) {
            $this->Attachment->create();
            $rstatus = $this->Attachment->save(array($this->Attachment->alias => array('file' => $file)));
            $retArray[] = $rstatus['Attachment']['path'];
        }
        return $retArray;
    }

}


?>
