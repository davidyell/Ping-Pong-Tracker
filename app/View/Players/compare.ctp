<div class="players compare">
    <h2>Compare players</h2>

    <?php
    echo $this->Form->create();
        echo $this->Form->input('player1', array('type'=>'select', 'options'=>$player_list, 'div'=>array('class'=>'input select player1'), 'after'=>'&nbsp;vs&nbsp;'));
        echo $this->Form->input('player2', array('type'=>'select', 'options'=>$player_list, 'div'=>array('class'=>'input select player2')));
        ?><div class="clearfix"><!-- blank --></div><?php
    echo $this->Form->end('Compare');
    ?>

    <?php
    if(isset($player1) && isset($player2)){
        echo $this->element('player-record', array('player'=>$player1[0], 'i'=>1));
        echo $this->element('player-record', array('player'=>$player2[0], 'i'=>2));
    }
    ?>
    <div class="clearfix"><!-- blank --></div>
</div>