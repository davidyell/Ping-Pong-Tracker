<div class="departments view">
    <h2><?php echo $department['Department']['name'];?></h2>
    <h4>Players</h4>
    <ul>
        <?php foreach($department['Player'] as $player):?>
            <li>
                <?php
                $name = $player['first_name']." ";
                if(!empty($player['nickname'])){
                    $name .= '"'.$player['nickname'].'" ';
                }
                $name .= $player['last_name'];

                echo $this->Html->link($name, array('controller'=>'players','action'=>'view',$player['id']));
                ?>
            </li>
        <?php endforeach;?>
    </ul>

    <h4>Record</h4>
    <?php echo $this->element('score-stats', array('wins'=>$results['wins'],'losses'=>$results['losses'],'total_points'=>$results['total_score']));?>
</div>