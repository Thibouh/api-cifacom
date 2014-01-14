<?php

class FilmsController{

	private $db;

	public function __construct(){

		//Connexion à la DB
		$this->db=new DB\SQL(
		    'mysql:host=localhost;port=3306;dbname=cinema','root','');
	}

	public function actionFind(){
		
		// On récupère les données de la DB
		$this->db->begin();
		$data = $this->db->exec('SELECT * FROM films');
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
		$id_film = F3::get('PARAMS.id_film');
		$data = $this->db->exec('SELECT * FROM films WHERE id_film =' . $id_film);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionSearchByDate(){
		$this->db->begin();
		$date = F3::get('PARAMS.parution_film');
		$data = $this->db->exec('SELECT * FROM films WHERE parution_film =' . $date);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionSearchByCategory() {
		$this->db->begin();
		$category = F3::get('PARAMS.category_film');

		$data = $this->db->exec('SELECT c.name_category, f.title_film, f.descr_film, f.author_film
								FROM films AS f
								LEFT JOIN category AS c
								ON  c.name_category = "' .$category .'"
		 ');
		$this->db->commit();
		Api::response(200 , $data);
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