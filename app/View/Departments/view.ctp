<div class="departments view">
    <h2><?php echo $department['Department']['name'];?></h2>
    <h4>Players</h4>
    <ul>
        <?php foreach($department['Player'] as $player):?>
            <li>
                <?php
                echo "<span class='gravatar'>".$this->Gravatar->image($player['email'], array('s'=>24,'d'=>'wavatar'))."</span>";

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
    <?php echo $this->element('score-stats', array('stats'=>$department_stats[0][0])); ?>
</div>