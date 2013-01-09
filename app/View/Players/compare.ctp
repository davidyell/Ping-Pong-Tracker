<div class="players compare">
    <h2>Compare players</h2>

    <?php
    echo $this->Form->create();
        echo $this->Form->input('player1', array('type'=>'select', 'options'=>$player_list, 'div'=>array('class'=>'input select player1'), 'after'=>'&nbsp;vs&nbsp;'));
        echo $this->Form->input('player2', array('type'=>'select', 'options'=>$player_list, 'div'=>array('class'=>'input select player2')));
        ?><div class="clearfix"><!-- blank --></div><?php
    echo $this->Form->end('Compare');
    ?>

    <?php if(isset($player1) && isset($player2)):?>
        <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped comparison">
            <tr>
                <th scope="col">&nbsp;</th>
                <td>
                    <h4>
                    <?php

                    echo "<span class='gravatar'>".$this->Gravatar->image($player1[0]['Player']['email'], array('s'=>32,'d'=>'wavatar'))."</span>";

                    $name = h($player1[0]['Player']['first_name']);
                    if(!empty($player1[0]['Player']['nickname'])){
                        $name .= ' "'.$player1[0]['Player']['nickname'].'"';
                    }
                    $name .= ' '.h($player1[0]['Player']['last_name']);

                    echo $this->Html->link($name, array('controller'=>'players','action'=>'view',$player1[0]['Player']['id']));

                    if($player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank'] > $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank']){
                        echo $this->Html->image('gold_star_medal_32.png', array('title'=>'Winner','alt'=>'Gold star medal'))." ";
                    }
                    ?>
                    </h4>
                </td>
                <td>
                    <h4>
                    <?php
                    echo "<span class='gravatar'>".$this->Gravatar->image($player2[0]['Player']['email'], array('s'=>32,'d'=>'wavatar'))."</span>";

                    $name = h($player2[0]['Player']['first_name']);
                    if(!empty($player2[0]['Player']['nickname'])){
                        $name .= ' "'.$player2[0]['Player']['nickname'].'"';
                    }
                    $name .= ' '.h($player2[0]['Player']['last_name']);

                    echo $this->Html->link($name, array('controller'=>'players','action'=>'view',$player2[0]['Player']['id']));

                    if($player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank'] > $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank']){
                        echo $this->Html->image('gold_star_medal_32.png', array('title'=>'Winner','alt'=>'Gold star medal'))." ";
                    }
                    ?>
                    </h4>
                </td>
            </tr>
            <tr>
                <th scope="col">Department</th>
                <td><?php echo $player1[0]['Department']['name'];?></td>
                <td><?php echo $player2[0]['Department']['name'];?></td>
            </tr>
            <tr>
                <th scope="col">Wins</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['wins']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['wins']; ?></td>
            </tr>
            <tr>
                <th scope="col">Losses</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['losses']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['losses']; ?></td>
            </tr>
            <tr>
                <th scope="col">Points difference</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['diff']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['diff']; ?></td>
            </tr>
            <tr>
                <th scope="col">Matches played</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_matches']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_matches']; ?></td>
            </tr>
            <tr>
                <th scope="col">Total points</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_score']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_score']; ?></td>
            </tr>
            <tr>
                <th scope="col">Winning points</th>
                <td><?php echo $player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['win_points']; ?></td>
                <td><?php echo $player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['win_points']; ?></td>
            </tr>
            <tr>
                <th scope="col">Win percent</th>
                <td><?php echo number_format($player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['win_percent']); ?>%</td>
                <td><?php echo number_format($player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['win_percent']); ?>%</td>
            </tr>
            <tr>
                <th scope="col">Rating</th>
                <td><?php echo number_format($player1[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank'],2); ?></td>
                <td><?php echo number_format($player2[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['rank'],2); ?></td>
            </tr>
        </table>
    <?php endif;?>

    <div class="clearfix"><!-- blank --></div>
</div>