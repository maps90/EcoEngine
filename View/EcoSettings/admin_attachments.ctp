<div class="attachments index">

    <h2><?php echo $title_for_layout; ?></h2>

    <div class="row-fluid">
        <div class="span12 actions">
            <?php
            echo $this->Form->create('Setting', array('type' => 'file'));
            ?>
            <div id="attachment-upload" class="tab-pane">
                <?php
                echo $this->Form->input('files', array(
                    'label' => __d('croogo', 'Upload'),
                    'type' => 'file',
                    'name' => 'data[Setting][Files][]',
                    'multiple' => $multi
                ));
                echo $this->Form->input('returnTo', array('type' => 'hidden', 'value' => $returnTo));
                ?>
            </div>
            <?php
            echo $this->Form->end('Upload');
            ?>
        </div>
    </div>