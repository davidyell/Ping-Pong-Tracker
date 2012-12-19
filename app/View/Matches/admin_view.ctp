<div class="matches view">
<h2><?php  echo __('Match'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($match['Match']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($match['Match']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($match['Match']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Match'), array('action' => 'edit', $match['Match']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Match'), array('action' => 'delete', $match['Match']['id']), null, __('Are you sure you want to delete # %s?', $match['Match']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Players'), array('controller' => 'players', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Player'), array('controller' => 'players', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Players'); ?></h3>
	<?php if (!empty($match['Player'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Nickname'); ?></th>
		<th><?php echo __('Dob'); ?></th>
		<th><?php echo __('Department Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($match['Player'] as $player): ?>
		<tr>
			<td><?php echo $player['id']; ?></td>
			<td><?php echo $player['name']; ?></td>
			<td><?php echo $player['nickname']; ?></td>
			<td><?php echo $player['dob']; ?></td>
			<td><?php echo $player['department_id']; ?></td>
			<td><?php echo $player['created']; ?></td>
			<td><?php echo $player['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'players', 'action' => 'view', $player['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'players', 'action' => 'edit', $player['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'players', 'action' => 'delete', $player['id']), null, __('Are you sure you want to delete # %s?', $player['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Player'), array('controller' => 'players', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
