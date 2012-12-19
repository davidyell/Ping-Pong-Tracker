<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
                <?php
                echo $this->Form->input('match_type_id', array('value'=>1, 'type'=>'hidden'));

		echo $this->Form->input('Player.1.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 1', 'selected'=>0));
		echo $this->Form->input('Player.2.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 2', 'selected'=>0));
                ?>

                <div class="scores">
                    <?php echo $this->Form->input('MatchesPlayer.1.score', array('label'=>'Score 1', 'after'=>' vs ')); ?>
                    <?php echo $this->Form->input('MatchesPlayer.2.score', array('label'=>'Score 2')); ?>
                    <div style="clear:both"><!-- blank --></div>
                </div>

                <?php
                echo $this->Form->input('notes');
                ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
