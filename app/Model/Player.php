<?php
App::uses('AppModel', 'Model');
/**
 * Player Model
 *
 * @property Department $Department
 * @property Match $Match
 */
class Player extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'first_name';

        public function getPlayers(){
            $players = $this->find('all', array(
                'contain'=>false,
                'fields'=>array('id','first_name','last_name')
            ));

            foreach($players as $p){
                $return[$p['Player']['id']] = $p['Player']['first_name'].' '.substr($p['Player']['last_name'], 0, 1);
            }

            $return[0] = 'Choose player';

            return $return;
        }

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


        public $hasMany = array(
            'MatchesPlayer'
        );

}
