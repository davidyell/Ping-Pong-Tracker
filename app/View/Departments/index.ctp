<div class="departments index">
    <h2>Departments</h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="department-ranks">
        <thead>
            <tr>
                <th data-sort="int">Rank</th>
                <th data-sort="float">Rating</th>
                <th data-sort="string">Name</th>
                <th data-sort="int">Won</th>
                <th data-sort="int">Lost</th>
                <th data-sort="flaot">Win %</th>
                <th data-sort="int" class="hidden-phone">Winning points</th>
                <th data-sort="int" class="hidden-phone">Total points</th>
                <th data-sort="int"><acronym title="Points difference">PD</acronym></th>
            </tr>
        </thead>
        <?php
        $i = 1;
        foreach($departments as $department): ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $this->Number->precision($department[0]['rank'],2);?></td>
                <td><?php echo $this->Html->link($department['Department']['name'], array('controller'=>'departments','action'=>'view',$department['Department']['id']));?></td>
                <td><?php echo $department[0]['wins'];?></td>
                <td><?php echo $department[0]['losses'];?></td>
                <td><?php echo $this->Number->precision($department[0]['win_percent'],0);?></td>
                <td class="hidden-phone"><?php echo $department[0]['win_points'];?></td>
                <td class="hidden-phone"><?php echo $department[0]['total_score'];?></td>
                <td><?php echo $department[0]['diff'];?></td>
            </tr>
        <?php 
        $i++;
        endforeach; ?>
    </table>
</div>
