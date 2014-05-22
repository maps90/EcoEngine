<?php
$name = explode('.', $key);
$name = end($name);
$field['cakeField']['value'] = $value;
if (isset($field['explain'])) {
    $field['cakeField']['after'] = '<div class="after">' . $field['explain'] . "</div>";
}
$params = $field['cakeField'];
echo $this->Form->input($name . '.id', array('type' => 'hidden', 'default' => $id));

?>
<div class="input file">
    <div class="input-append">
        <?php
        echo $this->Form->label($name . ".value", $params['label']);
        echo $this->Form->text($name . ".value", array('class' => 'span9') + $params);
        echo $this->Html->link(__d('ecoreng', 'Upload'), '#', array(
            'class' => 'btn btn-success',
            'onclick' => "window.open('" . $this->Html->url(array(
                'plugin' => 'EcoEngine',
                'controller' => 'EcoSettings',
                'action' => 'attachments',
                'admin' => true,
                '?' => array('multi' => 0, 'returnTo' => $name.'Value')
            )) . "', '_blank', 'width=800,height=350,toolbar=0,resizable=0')"
                )
        );
        ?>
    </div>
    <?php echo $params['after']; ?>
</div>
<?php
// This script registers a new field callback to manage the data that its returned
// from the upload action. The upload action returns an array with the uploaded file's
// path; in this case we just set the input to that value.
// Callback functions are set in SettingUtility.js
$script = <<<EOT
        registerCallback('{$name}Value', function(cArray){
            $('#{$name}Value').val(cArray[0]);
        });
EOT;
$this->Js->buffer($script);