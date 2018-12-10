<?php

class User{


	/**
	 * регистрация пользователя
	 */
	public static function register($name, $email, $password)
	{
		$db = Db::getConnection();

		$sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->bindParam(':password', $password, PDO::PARAM_STR);

		return $result->execute();
	}


	
	/**
	 * редактирование личных данных
	 */
	public static function edit($userId, $name, $password)
	{
			$db = Db::getConnection();

			$sql = "UPDATE user SET name = :name, password = :password WHERE id = :id";

			$result = $db->prepare($sql);
			$result->bindParam(':id', $userId, PDO::PARAM_INT);
			$result->bindParam(':name', $name, PDO::PARAM_STR);
			$result->bindParam(':password', $password, PDO::PARAM_STR);

			return $result->execute();

	}



	/**
	 * валидация формы
	 */

	/**
	 * имя не менее 2 символов
	 */
	public static function checkName($name)
	{
		if(strlen($name) >= 2){
			return true;
		}
		return false;
	}

	/**
	 * телефон не менее 6 символов
	 */
	public static function checkPhone($phone)
	{
		if(strlen($phone) >= 6){
			return true;
		}
		return false;
	}

	/**
	 * проверка email
	 */
	public static function checkEmail($email)
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		}
		return false;
	}

	/**
	 * пароль не менее 6 символов
	 */
	public static function checkPassword($password)
	{
		if(strlen($password) >= 6){
			return true;
		}
		return false;
	}


	public static function checkEmailExists($email)
	{
		$db = Db::getConnection();

		$sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

		$result = $db->prepare($sql);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->execute();

		if($result->fetchColumn()){
			return true;
		}
		return false;
	}



	/**
	 * авторизация пользователя
	 * Проверяем, существует ли пользователь с заданными $email и $password
	 * @param string $email
	 * @param string $password
	 * @return mixed : integer user id or false
	 */

	public static function checkUserData($email, $password)
	{

		$db = Db::getConnection();
		
		$sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

		$result = $db->prepare($sql);
		$result->bindParam(':email', $email, PDO::PARAM_INT);
		$result->bindParam(':password', $password, PDO::PARAM_INT);
		$result->execute();

		$user = $result->fetch();
		if($user) {
			return $user['id'];
		}

		return false;

	}

	public static function auth($userId)
	{
		$_SESSION['user'] = $userId;
	}


	/**
	 * проверяем авторизован ли пользователь
	 */
	public static function checkLogged()
	{
		// если пользователь есть, вернем его id
		if(isset($_SESSION['user'])){
			return $_SESSION['user'];
		}
		// иначе перенаправим на страницу авторизации
		header('Location: /user/login/');
	}



	public static function isGuest()
	{
		// если пользователь есть, вернем false
		if(isset($_SESSION['user'])){
			return false;
		}
		return true;
	}



	/**
	 * получаем информацию о пользователе
	 */
	public static function getUserById($userId)
	{

		$userId = intval($userId);

		if($userId){
			$db = Db::getConnection();

			$sql = 'SELECT * FROM user WHERE id = :id';

			$result = $db->prepare($sql);
			$result->bindParam(':id', $userId, PDO::PARAM_INT);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();

			return $result->fetch();
		}
	}





}