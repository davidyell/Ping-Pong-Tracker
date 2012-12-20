<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
                <?php
                echo $this->Form->input('match_type_id');

		echo $this->Form->input('Player.1.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 1', 'selected'=>0, 'div'=>array('class'=>'input select one'), 'after'=>' vs '));
		echo $this->Form->input('Player.2.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 2', 'selected'=>0, 'div'=>array('class'=>'input select two')));
		echo $this->Form->input('Player.3.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 1 partner', 'selected'=>0, 'div'=>array('class'=>'input select three'), 'after'=>' vs '));
		echo $this->Form->input('Player.4.id', array('type'=>'select', 'options'=>$players, 'label'=>'Player 2 partner', 'selected'=>0, 'div'=>array('class'=>'input select four')));
                ?>

                <div class="scores">
                    <?php echo $this->Form->input('MatchesPlayer.1.score', array('label'=>'Team 1 score', 'after'=>' vs ')); ?>
                    <?php echo $this->Form->input('MatchesPlayer.2.score', array('label'=>'Team 2 score')); ?>
                    <div style="clear:both"><!-- blank --></div>
                </div>

                <?php
                echo $this->Form->input('notes');
                ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
