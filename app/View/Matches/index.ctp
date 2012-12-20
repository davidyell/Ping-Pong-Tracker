<div class="matches index">
    <h2>Matches played</h2>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('match_type_id'); ?></th>
            <th><?php echo $this->Paginator->sort('created', 'Played'); ?></th>
            <th class="hidden-phone"><?php echo $this->Paginator->sort('notes'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach($matches as $match): ?>
            <tr>
                <td><?php echo h($match['Match']['id']); ?>&nbsp;</td>
                <td><?php echo h($match['MatchType']['name']); ?>&nbsp;</td>
                <td><?php echo $this->Time->niceShort($match['Match']['created']); ?>&nbsp;</td>
                <td class="hidden-phone"><?php echo h($match['Match']['notes']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Actions->actions($match['Match']['id'], array('v'));?>
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
