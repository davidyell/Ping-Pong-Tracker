<?php
/**
 * CakePHP DepartmentsController
 * @author david
 */

App::uses('AppController', 'Controller');

class DepartmentsController extends AppController {

/**
 * List all departments
 *
 * @return void
 */
	public function index() {
		$this->set('departments', $this->Department->Player->MatchesPlayer->getDepartmentRankings());
	}

/**
 * View a department and it's users
 *
 * @param int $id The id of the department
 * @return void
 */
	public function view($id) {
		// Get the department and it's players
		$department = $this->Department->find('first', [
			'contain' => [
				'Player' => [
					'fields' => ['id', 'first_name', 'nickname', 'last_name', 'email'],
				]
			],
			'conditions' => [
				'Department.id' => $id
			]
		]);

		// Get the departments scores
		$departmentStats = $this->Department->Player->MatchesPlayer->getDepartmentRankings($id);

		$this->set(compact('department', 'departmentStats'));
	}

}
