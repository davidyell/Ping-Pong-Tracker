<ul class="nav nav-tabs">
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'index')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Matches', array('controller'=>'matches','action'=>'index'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'add')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Add match', array('controller'=>'matches','action'=>'add'));?>
    </li>
</ul>