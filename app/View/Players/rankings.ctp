<div class="players rankings">
    <h2><?php echo __('Rankings'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Rating</th>
                <th>Player</th>
                <th>Won</th>
                <th>Lost</th>
                <th>Win %</th>
                <th>Winning points</th>
                <th>Total points</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            // Count down in reverse
            foreach($rankings as $player):
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo number_format($player[0]['rank'], 1);?></td>
                    <td><?php
                        echo $player['Player']['first_name'];
                        if(!empty($player['Player']['nickname'])){
                            echo " '{$player['Player']['nickname']}'";
                        }
                        echo ' '.$player['Player']['last_name'];
                    ?></td>
                    <td><?php echo $player[0]['wins'];?></td>
                    <td><?php echo $player[0]['losses'];?></td>
                    <td><?php echo number_format($player[0]['win_percent'], 0);?>%</td>
                    <td><?php echo $player[0]['win_points'];?></td>
                    <td><?php echo $player[0]['total_score'];?></td>
                </tr>
                <?php
                $i++;
            endforeach;?>
        </tbody>
    </table>
</div>
