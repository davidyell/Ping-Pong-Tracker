<div class="tournament index">
    <h2>Tournaments</h2>
    
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tournaments">
        <thead>
            <tr>
                <th data-sort="int">Id</th>
                <th data-sort="string">Name</th>
                <th data-sort="string">Competitors</th>
                <th data-sort="string">Champion</th>
                <th data-sort="date">Played</th>
            </tr>
        </thead>
        <?php
        $i = 1;
        foreach($tournaments as $tournament): ?>
            <tr>
                <td><?php echo $tournament['Tournament']['id'];?></td>
                <td><?php echo $this->Html->link($tournament['Tournament']['name'], array('controller'=>'tournaments','action'=>'play', $tournament['Tournament']['id']));?></td>
                <td><?php
                    var_dump(unserialize($tournament['Tournament']['competitors']));
                ?></td>
                <td><?php echo "CHAMP";?></td>
                <td><?php echo $this->Time->niceShort($tournament['Tournament']['created']);?></td>
            </tr>
        <?php 
        $i++;
        endforeach; ?>
    </table>
    
    <p class="hidden-phone">
        <?php
        echo $this->Paginator->counter(array(
            'format'=>__('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>
    </p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< '.__('previous'), array(), null, array('class'=>'prev disabled'));
        echo $this->Paginator->numbers(array('separator'=>''));
        echo $this->Paginator->next(__('next').' >', array(), null, array('class'=>'next disabled'));
        ?>
    </div>
</div>