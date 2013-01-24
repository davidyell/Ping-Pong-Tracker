<div class="players rankings">
    <h2><?php echo __('Rankings'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="rankings">
        <thead>
            <tr>
                <th data-sort="int">Rank</th>
                <th data-sort="float">Rating</th>
                <th data-sort="float">Singles PR</th>
                <th data-sort="string">Player</th>
                <th data-sort="int">Won</th>
                <th data-sort="int">Lost</th>
                <th data-sort="flaot">Win %</th>
                <th data-sort="int" class="hidden-phone">Winning points</th>
                <th data-sort="int" class="hidden-phone">Total points</th>
                <th data-sort="int"><acronym title="Points difference">PD</acronym></th>
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
                    <td><?php echo $this->Number->precision($player[0]['rank'], 1);?></td>
                    <td><?php echo $this->Number->precision($player['Player']['performance_rating'],0);?></td>
                    <td><?php
                        echo "<span class='gravatar'>".$this->Gravatar->image($player['Player']['email'], array('s'=>24,'d'=>'wavatar'))."</span>";
                        
                            $name = $player['Player']['first_name'];
                            if(!empty($player['Player']['nickname'])){
                                $name .= " '{$player['Player']['nickname']}'";
                            }
                            $name .= ' '.$player['Player']['last_name'];
                        echo $this->Html->link($name, array('controller'=>'players','action'=>'view',$player['Player']['id']));

                    ?></td>
                    <td><?php echo $player[0]['wins'];?></td>
                    <td><?php echo $player[0]['losses'];?></td>
                    <td><?php echo $this->Number->precision($player[0]['win_percent'], 0);?>%</td>
                    <td class="hidden-phone"><?php echo $player[0]['win_points'];?></td>
                    <td class="hidden-phone"><?php echo $player[0]['total_score'];?></td>
                    <td><?php echo $player[0]['diff'];?></td>
                </tr>
                <?php
                $i++;
            endforeach;?>
        </tbody>
    </table>
</div>
