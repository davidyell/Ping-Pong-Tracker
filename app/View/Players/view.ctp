<div class="players view">
    <h2>
        Player profile: <?php
        echo h($player['Player']['first_name']);
        if(!empty($player['Player']['nickname'])){
            echo ' "'.$player['Player']['nickname'].'" ';
        }
        echo h($player['Player']['last_name']);
        ?>
    </h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($player['Player']['id']); ?>
		</dd>
		<dt><?php echo __('Dob'); ?></dt>
		<dd>
			<?php echo h($player['Player']['dob']); ?>
		</dd>
		<dt><?php echo __('Department'); ?></dt>
		<dd>
			<?php echo $this->Html->link($player['Department']['name'], array('controller' => 'departments', 'action' => 'view', $player['Department']['id'])); ?>
		</dd>
		<dt>Joined</dt>
		<dd>
			<?php echo $this->Time->niceShort($player['Player']['created']); ?>
		</dd>
                <dt>Latest victory</dt>
                <dd>
                    <?php
                    // TODO: This needs sorting out. I reckon using Set::extract() will be better. Also look at the Controller.
                    foreach($matches as $match){
                        if($match['MatchesPlayer']['result'] == 'Won'){
                            if($match['Match']['MatchType']['id'] == 2){ // Doubles
                                $against = $match['Match']['MatchesPlayer'][1]['Player']['first_name']." & ".$match['Match']['MatchesPlayer'][3]['Player']['first_name'];
                            }else{
                                $against = $match['Match']['MatchesPlayer'][1]['Player']['first_name'];
                            }
                            echo "<div class='alert alert-success'>Won a {$match['Match']['MatchType']['name']} match against $against ".$this->Time->niceShort($match['Match']['created']);
                            break;
                        }
                    }
                    ?>
                </dd>
                <dt>Latest defeat</dt>
                <dd>
                    <?php
                    // TODO: This needs sorting out. I reckon using Set::extract() will be better. Also look at the Controller.
                    foreach($matches as $match){
                        if($match['MatchesPlayer']['result'] == 'Lost'){
                            if($match['Match']['MatchType']['id'] == 2){ // Doubles
                                $against = $match['Match']['MatchesPlayer'][0]['Player']['first_name']." & ".$match['Match']['MatchesPlayer'][2]['Player']['first_name'];
                            }else{
                                $against = $match['Match']['MatchesPlayer'][0]['Player']['first_name'];
                            }
                            echo "<div class='alert alert-error'>Lost a {$match['Match']['MatchType']['name']} match against $against ".$this->Time->niceShort($match['Match']['created']);
                            break;
                        }
                    }
                    ?>
                </dd>
                <dt>Win:Loss</dt>
                <dd>
                    <?php echo $this->element('score-stats', array('wins'=>$wins,'losses'=>$losses,'total_points'=>$score_total));?>
                </dd>
	</dl>
</div>

