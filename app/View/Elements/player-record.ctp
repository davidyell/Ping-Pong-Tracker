<div class="player<?php echo $i; ?> well">
    <h4><?php
echo h($player['Player']['first_name']);
if(!empty($player['Player']['nickname'])){
    echo ' "'.$player['Player']['nickname'].'"';
}
echo ' '.h($player['Player']['last_name']);
?></h4>
    <dl>
        <dt>Department</dt>
        <dd><?php echo $this->Html->link($player['Department']['name'], array('controller'=>'departments', 'action'=>'view', $player['Department']['id'])); ?></dd>
        <dt>Wins</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['wins']; ?></dd>
        <dt>Losses</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['losses']; ?></dd>
        <dt>Points difference</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['diff']; ?></dd>
        <dt>Total matches</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['total_matches']; ?></dd>
        <dt>Points total</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['total_score']; ?></dd>
        <dt>Winning points</dt>
        <dd><?php echo $player['MatchesPlayer'][0]['MatchesPlayer'][0]['win_points']; ?></dd>
        <dt>Win percent</dt>
        <dd><?php echo number_format($player['MatchesPlayer'][0]['MatchesPlayer'][0]['win_percent']); ?>%</dd>
        <dt>Rating</dt>
        <dd><?php echo number_format($player['MatchesPlayer'][0]['MatchesPlayer'][0]['rank'], 2); ?>%</dd>
    </dl>
</div>