<?php
/**
 * CakePHP DepartmentsController
 * @author david
 */

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController {

        public function index(){
            $this->Department->recursive = 0;
            $this->set('departments', $this->paginate());
        }
    
	public function view($id){
            // Get the department and it's players
            $department = $this->Department->find('first', array(
                'contain'=>array(
                    'Player'=>array(
                        'fields'=>array('id','first_name','nickname','last_name'),
                    )
                ),
                'conditions'=>array(
                    'Department.id'=>$id
                )
            ));

            foreach($department['Player'] as $player){
                $player_ids[] = $player['id'];
            }

            // Get the departments scores
            $results = $this->Department->Player->MatchesPlayer->getResults($player_ids);

            $this->set(compact('department', 'results'));
        }
        
}
