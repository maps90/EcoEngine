<?php
$this->extend('/Common/admin_edit');
$this->Html
        ->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb('EcoEngine', array('controller' => 'Settings', 'action' => 'install', 'admin' => true));
?>
<div class="row-fluid">
    <div class="span8">

        <ul class="nav nav-tabs">
            <?php
            echo $this->Croogo->adminTab(__d('croogo', 'Setup'), '#main');
            ?>
        </ul>

        <div class="tab-content">

            <div id="main" class="tab-pane">
                <h3>EcoEngine Setup</h3>
                <table class="table">
                    <tbody>
                        <tr class="<?php echo $theme['EcoEngine']['support'] ? "success" : "error"; ?>">
                            <td>EcoEngine Support:</td>
                            <td><?php echo $theme['EcoEngine']['support'] ? "Yes" : "No"; ?></td>
                        </tr>
                        <tr class="<?php echo $theme['EcoEngine']['installed'] ? "success" : "error"; ?>">
                            <td>EcoEngine Installed:</td>
                            <td><?php echo $theme['EcoEngine']['installed'] ? "Yes" : "No"; ?></td>
                        </tr>
                        <tr>
                            <td>Setup file:</td>
                            <td><?php echo str_replace(APP,'',$theme['EcoEngine']['file']); ?></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="span4">
        <?php
        echo $this->Html->beginBox(__d('croogo', 'Actions'));      
        echo $this->Html->link(__d('croogo', 'Install'), array('action' => 'installation'), array('class' => 'cancel btn btn-primary'));
        echo $this->Html->link(__d('croogo', 'Unset all'), array('action' => 'reset'), array('class' => 'cancel btn btn-danger'));
        echo $this->Html->endBox();
        ?>
    </div>
</div>



