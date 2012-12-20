<div class="players index">
    <h2><?php echo __('Players'); ?></h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th><?php echo $this->Paginator->sort('first_name'); ?></th>
            <th class="hidden-phone"><?php echo $this->Paginator->sort('nickname'); ?></th>
            <th><?php echo $this->Paginator->sort('last_name'); ?></th>
            <th><?php echo $this->Paginator->sort('department_id'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach($players as $player): ?>
            <tr>
                <td><?php echo h($player['Player']['first_name']); ?>&nbsp;</td>
                <td class="hidden-phone"><?php echo h($player['Player']['nickname']); ?>&nbsp;</td>
                <td><?php echo h($player['Player']['last_name']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($player['Department']['name'], array('controller'=>'departments', 'action'=>'view', $player['Department']['id'])); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Actions->actions($player['Player']['id'], array('v')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p class="hidden-phone">
        <?php
        echo $this->Paginator->counter(array(
            'format'=>__('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< '.__('previous'), array(), null, array('class'=>'prev disabled'));
        echo $this->Paginator->numbers(array('separator'=>''));
        echo $this->Paginator->next(__('next').' >', array(), null, array('class'=>'next disabled'));
        ?>
    </div>
</div>
