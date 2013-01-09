<div class="players rankings">
    <h2><?php echo __('Rankings'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped" id="rankings">
        <thead>
            <tr>
                <th data-sort="int">Rank</th>
                <th data-sort="float">Rating</th>
                <th data-sort="string">Player</th>
                <th data-sort="int">Won</th>
                <th data-sort="int">Lost</th>
                <th data-sort="int">GD</th>
                <th data-sort="flaot">Win %</th>
                <th data-sort="int" class="hidden-phone">Winning points</th>
                <th data-sort="int" class="hidden-phone">Total points</th>
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
                            $name = $player['Player']['first_name'];
                            if(!empty($player['Player']['nickname'])){
                                $name .= " '{$player['Player']['nickname']}'";
                            }
                            $name .= ' '.$player['Player']['last_name'];
                        echo $this->Html->link($name, array('controller'=>'players','action'=>'view',$player['Player']['id']));

                    ?></td>
                    <td><?php echo $player[0]['wins'];?></td>
                    <td><?php echo $player[0]['losses'];?></td>
                    <td><?php echo $player[0]['diff'];?></td>
                    <td><?php echo number_format($player[0]['win_percent'], 0);?>%</td>
                    <td class="hidden-phone"><?php echo $player[0]['win_points'];?></td>
                    <td class="hidden-phone"><?php echo $player[0]['total_score'];?></td>
                </tr>
                <?php
                $i++;
            endforeach;?>
        </tbody>
    </table>
</div>

<?php
$this->Blocks->append('script');
    echo $this->Html->script('stupidtable.min');
    ?>
    <script type="text/javascript">
        $(function(){
            $('#rankings').stupidtable();
        })
    </script>
<?php $this->Blocks->end();?>