<div class="players rankings">
    <h2><?php echo __('Rankings'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="rankings">
        <thead>
            <tr>
                <th data-sort="int">Rank <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="float">Rating <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="float">Singles <abbr class="initialism" title="Performance rating">PR</abbr> <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="string">Player <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="int">Won <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="int">Lost <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="flaot">Win % <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="int" class="hidden-phone">Winning points <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="int" class="hidden-phone">Total points <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
                <th data-sort="int"><abbr class="initialism" title="Points difference">PD</abbr> <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></th>
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
                        echo $this->element('player-avatar', array('player'=>$player, 'size'=>24), array('cache'=>array('config'=>'twoweeks','key'=>'player_'.$player['Player']['id'].'_24')));
                        
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
