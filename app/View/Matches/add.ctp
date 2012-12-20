<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
                <?php
                echo $this->Form->input('match_type_id');

                $nums = array(
                    1=>'one',
                    2=>'two',
                    3=>'three',
                    4=>'four'
                );

                $vs = array('after'=>'&nbsp;vs&nbsp;');

                for($i = 1; $i <= 4; $i++){

                    $options = array('type'=>'select', 'options'=>$players, 'div'=>array('class'=>'input select '.$nums[$i]));
                    $selected = array('selected'=>0);
                    $label = array('label'=>'Player '.$nums[$i]);
                    
                    if(isset($this->request->data['MatchesPlayer'][$i]['id']) && $this->request->data['MatchesPlayer'][$i]['id'] != 0){
                        $selected = array('selected'=>$this->request->data['MatchesPlayer'][$i]['id']);
                    }
                    $options = array_merge($options, $selected);
                    
                    if($i == 1 || $i == 3){
                        $options = array_merge($options, $vs);
                    }
                    if($i == 3 || $i == 4){
                        $options = array_merge($options, array('label'=>'Player '.$nums[$i-2].' partner'));
                    }else{
                        $options = array_merge($options, $label);
                    }
                    
                    echo $this->Form->input('MatchesPlayer.'.$i.'.player_id', $options);
                }

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
