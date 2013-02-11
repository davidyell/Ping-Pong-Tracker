<div class="tournament view">
    <h2>Tournament</h2>
    <?php echo $this->Html->image('../files/tournaments/'.$tournament['Tournament']['id'].'/tournament_'.$tournament['Tournament']['id'].'.png');?>
    
    <?php
    echo $this->Form->create('Match');
    
    foreach($tournament['Match'] as $match){
        ?><div class="match">
            <div class="scores"><?php
                $person = $this->element('player-avatar', array('player'=>$match['MatchesPlayer'][0]['Player'], 'size'=>24), array('cache'=>array('config'=>'twoweeks','key'=>'player_'.$match['MatchesPlayer'][0]['Player']['id'].'_24')));

                $person .= h($match['MatchesPlayer'][0]['Player']['first_name']);
                if(!empty($match['MatchesPlayer'][0]['Player']['nickname'])){
                    $person .= ' "'.$match['MatchesPlayer'][0]['Player']['nickname'].'"';
                }
                $person .= ' '.h($match['MatchesPlayer'][0]['Player']['last_name']);

                echo $this->Form->input('MatchesPlayer.1.score', array('before'=>$person, 'after'=>'&nbsp;vs&nbsp;'));
                

                $person = $this->element('player-avatar', array('player'=>$match['MatchesPlayer'][1]['Player'], 'size'=>24), array('cache'=>array('config'=>'twoweeks','key'=>'player_'.$match['MatchesPlayer'][1]['Player']['id'].'_24')));

                $person .= h($match['MatchesPlayer'][1]['Player']['first_name']);
                if(!empty($match['MatchesPlayer'][1]['Player']['nickname'])){
                    $person .= ' "'.$match['MatchesPlayer'][1]['Player']['nickname'].'"';
                }
                $person .= ' '.h($match['MatchesPlayer'][1]['Player']['last_name']);

                echo $this->Form->input('MatchesPlayer.2.score', array('before'=>$person));
            ?>
                <div style="clear:both"><!-- blank --></div>
            </div>
        </div><?php
    }
    
    echo $this->Form->button('Save and progress', array('type'=>'submit', 'class'=>'btn'));
    echo $this->Form->end();
    ?>
</div>