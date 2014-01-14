<?php

class UsersController{

	private $db;

	public function __construct(){

		//Connexion à la DB
		$this->db=new DB\SQL(
		    'mysql:host=localhost;port=3306;dbname=cinema','root','');

	}

	public function actionFind(){
		
		// On récupère les données de la DB
		$this->db->begin();
		$data = $this->db->exec('SELECT * FROM users');
		$this->db->commit();

		// On envoie le tout avec l'api
		Api::response(200, $data);
	}

	public function actionCreate(){
		if(isset($_POST['name'])){
			$data = array('Create dog with name ' . $_POST['name']);
			Api::response(200, $data);
		}
		else{
			Api::response(400, array('error'=>'Name is missing'));
		}
	}

	public function actionFindOne(){
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');
		$data = $this->db->exec('SELECT * FROM users WHERE id_user =' . $id_user);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionUpdate(){
		$data = array('Update dog with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}

	public function actionDelete(){

		$data = array('Delete dog with name: ' . F3::get('PARAMS.id'));
		Api::response(200, $data);
	}
}