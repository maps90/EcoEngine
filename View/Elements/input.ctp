<?php
    $name = end(explode('.', $key));
    $field['cakeField']['value'] = $value;
    if(isset($field['explain'])) {
        $field['cakeField']['after'] = '<div class="after">' . $field['explain'] . "</div>";
    }
    $params = $field['cakeField'];
    echo $this->Form->input($name . '.id', array('type' => 'hidden', 'default' => $id ));
    echo $this->Form->input($name . ".value", $params);
    
?>