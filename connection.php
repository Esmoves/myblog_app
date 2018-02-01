<?php

class Connection{

	public function dbConnect(){
		return new PDO("mysql:host=localhost;dbname=myblog;charset=utf8mb4", "root", "");
	}
}

