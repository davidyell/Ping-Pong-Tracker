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
                    $against = '';
                    $losing_team = Set::extract("/MatchesPlayer[result=Lost]", $last_win);
                    foreach($losing_team as $p){
                        $against .= $p['MatchesPlayer']['Player']['first_name'].' '.substr($p['MatchesPlayer']['Player']['last_name'], 0, 1).', ';
                    }
                    $against = rtrim($against, ", ");
                    echo $this->Html->link("Won a <b>{$last_loss['MatchType']['name']}</b> match against <b>$against</b> ".$this->Time->niceShort($last_loss['Match']['created']), array('controller'=>'matches','action'=>'view',$last_win['Match']['id']), array('escape'=>false));
                    ?>
                </dd>
                <dt>Latest defeat</dt>
                <dd>
                   <?php
                    $against = '';
                    $winning_team = Set::extract("/MatchesPlayer[result=Won]", $last_loss);
                    foreach($winning_team as $p){
                        $against .= $p['MatchesPlayer']['Player']['first_name'].' '.substr($p['MatchesPlayer']['Player']['last_name'], 0, 1).', ';
                    }
                    $against = rtrim($against, ", ");
                    echo $this->Html->link("Lost a <b>{$last_loss['MatchType']['name']}</b> match against <b>$against</b> ".$this->Time->niceShort($last_loss['Match']['created']), array('controller'=>'matches','action'=>'view',$last_loss['Match']['id']), array('escape'=>false));
                    ?>
                </dd>
                <dt>Win:Loss</dt>
                <dd>
                    <?php echo $this->element('score-stats', array('wins'=>$results['wins'],'losses'=>$results['losses'],'total_points'=>$results['total_score']));?>
                </dd>
	</dl>
</div>

