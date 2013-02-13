<div class="tournament view">
    <h2>Tournament</h2>
    <?php echo $this->Html->image('../files/tournaments/'.$tournament['Tournament']['id'].'/tournament_'.$tournament['Tournament']['id'].'.png', array('id'=>'tournament-draw'));?>
    <div style="clear:both"><!-- blank --></div>
    
    <?php
    foreach($tournament['Match'] as $matchNum => $match){
        if(!empty($match['MatchesPlayer'])):
            ?><div class="match">
                <?php
                echo $this->Form->create('Match', array('url'=>array('controller'=>'matches','action'=>'ajax_edit.json')));
                    echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$match['id']));
                    echo $this->Form->input('match_type_id', array('type'=>'hidden', 'value'=>1));
                    echo $this->Form->input('Tournament.competitors', array('type'=>'hidden', 'value'=>$tournament['Tournament']['competitors']));
                    echo $this->Form->input('Tournament.id', array('type'=>'hidden', 'value'=>$tournament['Tournament']['id']));
                    echo $this->Form->input('Tournament.name', array('type'=>'hidden', 'value'=>$tournament['Tournament']['name']));
                    echo $this->Form->input('Tournament.round', array('type'=>'hidden', 'value'=>$match['tournament_round']));
                    echo $this->Form->input('Tournament.match', array('type'=>'hidden', 'value'=>$match['tournament_match_num']));
                    ?>
                    <div class="scores"><?php
                        $person = h($match['MatchesPlayer'][0]['Player']['first_name']);
                        if(!empty($match['MatchesPlayer'][0]['Player']['nickname'])){
                            $person .= ' "'.$match['MatchesPlayer'][0]['Player']['nickname'].'"';
                        }
                        $person .= ' '.h($match['MatchesPlayer'][0]['Player']['last_name']);

                        echo $this->Form->input('MatchesPlayer.1.id', array('type'=>'hidden', 'value'=>$match['MatchesPlayer'][0]['id']));
                        echo $this->Form->input('MatchesPlayer.1.score', array('before'=>$person, 'after'=>'&nbsp;vs&nbsp;', 'value'=>$match['MatchesPlayer'][0]['score']));
                        echo $this->Form->input('MatchesPlayer.1.player_id', array('type'=>'hidden', 'value'=>$match['MatchesPlayer'][0]['Player']['id']));


                        $person = h($match['MatchesPlayer'][1]['Player']['first_name']);
                        if(!empty($match['MatchesPlayer'][1]['Player']['nickname'])){
                            $person .= ' "'.$match['MatchesPlayer'][1]['Player']['nickname'].'"';
                        }
                        $person .= ' '.h($match['MatchesPlayer'][1]['Player']['last_name']);

                        echo $this->Form->input('MatchesPlayer.2.id', array('type'=>'hidden', 'value'=>$match['MatchesPlayer'][1]['id']));
                        echo $this->Form->input('MatchesPlayer.2.score', array('before'=>$person, 'value'=>$match['MatchesPlayer'][1]['score']));
                        echo $this->Form->input('MatchesPlayer.2.player_id', array('type'=>'hidden', 'value'=>$match['MatchesPlayer'][1]['Player']['id']));
                    ?>
                        <div style="clear:both"><!-- blank --></div>
                    </div>
                    <?php
                    echo $this->Form->button('Save match', array('type'=>'submit', 'class'=>'btn'));
                    echo $this->Form->end();
                    ?>
            </div><?php
        endif;
    }
    ?>
    <div style="clear:both"><!-- blank --></div>
</div>