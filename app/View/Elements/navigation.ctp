<ul class="nav nav-pills">
    <li <?php echo ($this->request->controller == 'pages')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Home', array('controller'=>'pages','action'=>'display','home'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'add')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Add match', array('controller'=>'matches','action'=>'add'));?>
    </li>
    <li <?php echo ($this->request->controller == 'players' && $this->request->action == 'rankings')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Player rankings', array('controller'=>'players','action'=>'rankings'));?>
    </li>
    <li <?php echo ($this->request->controller == 'departments')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Department rankings', array('controller'=>'departments','action'=>'index'));?>
    </li>
    <li <?php echo ($this->request->controller == 'players' && $this->request->action == 'compare')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Player comparison', array('controller'=>'players','action'=>'compare'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'global_stats')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Global stats', array('controller'=>'matches','action'=>'global_stats'));?>
    </li>
    <li <?php echo ($this->request->controller == 'matches' && ($this->request->action == 'index' || $this->request->action == 'view'))? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Match list', array('controller'=>'matches','action'=>'index'));?>
    </li>
    <li <?php echo ($this->request->controller == 'players' && ($this->request->action == 'index' || $this->request->action == 'view'))? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Player list', array('controller'=>'players','action'=>'index'));?>
    </li>
</ul>