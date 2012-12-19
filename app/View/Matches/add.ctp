<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
                <?php
                echo $this->Form->input('type', array('options'=>array(2=>'Singles',4=>'Doubles')));

		echo $this->Form->input('Player.1.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 1'));
		echo $this->Form->input('Player.2.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 2'));
		echo $this->Form->input('Player.3.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 3'));
		echo $this->Form->input('Player.4.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 4'));
                ?>

                <div class="scores">
                    <?php echo $this->Form->input('score.0', array('label'=>'Score 1', 'after'=>' vs ')); ?>
                    <?php echo $this->Form->input('score.1', array('label'=>'Score 2')); ?>
                    <div style="clear:both"><!-- blank --></div>
                </div>

                <?php
                echo $this->Form->input('notes');
                ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
