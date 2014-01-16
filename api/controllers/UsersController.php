<?php

class UsersController{

	private $db;

	public function __construct(){

		//Connexion à la DB
		$this->
db=new DB\SQL(
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
		$this->db->begin();
		$data = $this->db->exec('INSERT INTO users (pseudo_user, email_user, mdp_user, token) 
								VALUES ( "'. F3::get('POST.pseudo'). '", "'. F3::get('POST.email'). '", "'. F3::get('POST.mdp'). '","'. F3::get('POST.token'). '" )');
		$this->db->commit();

		Api::response(200, $data);
	}

	public function actionFindOne(){
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');
		$data = $this->db->exec('SELECT * FROM users WHERE id_user =' . $id_user);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionUpdate(){
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');
		$array = Put::get();

		$data = $this->db->exec('UPDATE users SET
		pseudo_user = "'. $array['pseudo'] . '",
		email_user  = "'. $array['email'] . '",
		mdp_user    = "'. $array['mdp'] . '",
		token 	    = "'. $array['token'] . '"
		WHERE id_user = ' . $id_user);
		$this->db->commit();

		Api::response(200, $data);
	}

	public function actionDelete(){
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');

		$data = $this->db->exec('DELETE FROM users WHERE id_user =' . $id_user);
		$this->db->commit();

		Api::response(200, $data);
	}

	public function actionWillSee() {
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');

		$data = $this->db->exec(
			'SELECT * FROM 
			`films` f LEFT JOIN `will_see` w ON w.`id_film` = f.`id_film`
					   LEFT JOIN `users` u ON u.`id_user` = w.`id_user`
					   WHERE u.`id_user`=' . $id_user);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionAlReadySee() {
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');

		$data = $this->db->exec(
			'SELECT * FROM 
			`films` f LEFT JOIN `already_see` a ON a.`id_film` = f.`id_film`
					   LEFT JOIN `users` u ON u.`id_user` = a.`id_user`
					   WHERE u.`id_user`=' . $id_user);
		$this->db->commit();
		Api::response(200, $data);
	}

	public function actionLike() {
		$this->db->begin();
		$id_user = F3::get('PARAMS.id_user');

		$data = $this->db->exec(
			'SELECT * FROM 
			`films` f LEFT JOIN `like_user` lu ON lu.`id_film` = f.`id_film`
					   LEFT JOIN `users` u ON u.`id_user` = lu.`id_user`
					   WHERE u.`id_user`=' . $id_user);
		$this->db->commit();
		Api::response(200, $data);
	}	


}