<?php
$this->theme = $theme['EcoEngine']['theme'];
$this->Html->script('/EcoEngine/js/SettingUtility.js', false);
$this->extend('/Common/admin_edit');
echo $this->Html->css('/EcoEngine/css/fields.css', null, array('inline' => false));

$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Theme Options'));

echo $this->Form->create('Setting');
$this->Form->inputDefaults(array(
    'class' => 'span10',
));
?>
<div class="row-fluid">
    <div class="span8">

        <ul class="nav nav-tabs">
            <?php
            echo $this->Croogo->adminTab(__d('ecoreng', 'Theme'), '#theme-main');
            echo $this->Croogo->adminTabs();
            ?>
        </ul>

        <div class="tab-content">

            <div id="theme-main" class="tab-pane">
                <?php
                $SettingsF = Hash::extract($Settings, '{n}.Setting[key=/^((?!\.assembly$)[\w.-])+$/]');
                $Assembly = Hash::extract($Settings, '{n}.Setting[key=/\.assembly/]');
                $Settings = Hash::combine(array($SettingsF, $Assembly), '{n}.{n}.key', '{n}.{n}.value');
                foreach ($SettingsF as $setting) {
                    $field = json_decode($Settings[$setting['key'] . '.assembly'], true);
                    ?>

                    <?php
                    $data = $this->EcoEngine->element($field['type'], $theme['EcoEngine']['theme']);
                    // Bypass Croogo admin theme limitation by setting the theme manually
                    echo $this->element(
                            $data['element']
                            , array('id' => $setting['id'], 'key' => $setting['key'], 'value' => $setting['value'], 'field' => $field));
                    // and then unsetting it
                    ?>
                    <?php
                }
                ?>
            </div>

            <?php echo $this->Croogo->adminTabs(); ?>
        </div>

    </div>
    <div class="span4">
        <?php
        echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
        $this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply', 'class' => 'btn')) .
        $this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
        $this->Html->link(__d('croogo', 'Cancel'), array('plugin' => 'settings', 'controller' => 'settings', 'action' => 'dashboard', 'admin' => true, 'prefix' => 'admin'), array('class' => 'cancel btn btn-danger'));

        echo $this->Html->endBox();

        echo $this->Croogo->adminBoxes();
        $this->theme = Configure::read('Site.admin_theme');
        ?>
    </div>
</div>
