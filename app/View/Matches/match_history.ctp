<div class="matches history">
    <?php
    $name = $player['Player']['first_name'];
    if(!empty($player['Player']['nickname'])){
        $name .= " '".$player['Player']['nickname']."' ";
    }
    $name .= ' '.$player['Player']['last_name'];
    ?>
    <h2><?php echo $name;?> match history</h2>
    
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('match_type_id'); ?></th>
                <th>Players</th>
                <th><?php echo $this->Paginator->sort('created', 'Played'); ?></th>
                <th class="hidden-phone"><?php echo $this->Paginator->sort('notes'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody id="matches-tbody">
            <?php echo $this->element('matches-index-table');?>
        </tbody>
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