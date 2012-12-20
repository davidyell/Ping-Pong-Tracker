<div class="departments index">
    <h2>Departments</h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach($departments as $department): ?>
            <tr>
                <td><?php echo h($department['Department']['name']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Actions->actions($department['Department']['id'], array('v'));?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
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
