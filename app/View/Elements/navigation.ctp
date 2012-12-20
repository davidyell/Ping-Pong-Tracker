<ul class="nav nav-pills">
    <li <?php echo ($this->request->controller == 'pages')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Home', array('controller'=>'pages','action'=>'display','home'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'add')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Add match', array('controller'=>'matches','action'=>'add'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && ($this->request->action == 'index' || $this->request->action == 'view'))? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Matches', array('controller'=>'matches','action'=>'index'));?>
    </li>
    <li <?php echo ($this->request->controller == 'players')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Players', array('controller'=>'players','action'=>'index'));?>
    </li>
    <li <?php echo ($this->request->controller == 'departments')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Departments', array('controller'=>'departments','action'=>'index'));?>
    </li>
</ul>