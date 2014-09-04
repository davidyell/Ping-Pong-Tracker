<?php
/**
 * CakePHP DepartmentsController
 * @author david
 */

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController {

	public function index() {
		$this->set('departments', $this->Department->Player->MatchesPlayer->getDepartmentRankings());
	}

	public function view($id) {
		// Get the department and it's players
		$department = $this->Department->find('first', [
			'contain' => [
				'Player' => [
					'fields' => ['id','first_name','nickname','last_name','email'],
				]
			],
			'conditions' => [
				'Department.id' => $id
			]
		]);

		foreach ($department['Player'] as $player) {
			$player_ids[] = $player['id'];
		}

		// Get the departments scores
		$department_stats = $this->Department->Player->MatchesPlayer->getDepartmentRankings($id);

		$this->set(compact('department','department_stats'));
	}

}
