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
		$this->db->begin();
		$data = $this->db->exec('INSERT INTO films (title_film, descr_film, author_film, actor_film, category_film, parution_film, rate_film) 
								VALUES ( "'. F3::get('POST.title'). '", "'. F3::get('POST.descr'). '", "'. F3::get('author'). '","'. F3::get('POST.actor'). '","'. F3::get('POST.category'). '","'. F3::get('POST.parution'). '","'. F3::get('POST.rate'). '" )');
		$this->db->commit();

		Api::response(200, $data);
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
		$this->db->begin();
		$id_film = F3::get('PARAMS.id_film');
		$array = Put::get();

		$data = $this->db->exec('UPDATE films SET
		title_film = "'. $array['title'] . '",
		descr_film  = "'. $array['descr'] . '",
		author_film    = "'. $array['author'] . '",
		actor_film 	    = "'. $array['actor'] . '"
		rate_film 	    = "'. $array['rate'] . '"
		parution_film 	    = "'. $array['parution'] . '"
		category_film 	    = "'. $array['category'] . '"
		WHERE id_film = ' . $id_film);
		$this->db->commit();

		Api::response(200, $data);
	}

	public function actionDelete(){
		$this->db->begin();
		$id_film = F3::get('PARAMS.id_film');

		$data = $this->db->exec('DELETE FROM films WHERE id_film =' . $id_film);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionAddWillSee(){

	}
}