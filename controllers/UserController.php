<?php

// контроллер для регистрации пользователей

class UserController{

	public function actionRegister()
	{

		$name='';
		$email='';
		$password='';
		$result = false;

		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];

			$errors = false;

			if(!User::checkName($name)){
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}

			if(!User::checkEmail($email)){
				$errors[] = 'Неправильный email';
			}

			if(!User::checkPassword($password)){
				$errors[] = 'Пароль не должен быть короче 6-ти символов';
			}

			if(User::checkEmailExists($email)){
				$errors[] = 'Такой email уже используется'; 
			}


			if(!$errors){
				// обрабатываем форму дальше
				$result = User::register($name, $email, $password);
			}


		}

		require_once(ROOT.'/views/user/register.php');
		return true;
	}

	public function actionLogin()
	{
		$email = '';
		$password = '';

		if(isset($_POST['submit'])){

			$email = $_POST['email'];
			$password = $_POST['password'];

			$errors = false;

			// валидация полей
			if(!User::checkEmail($email)){
				$errors[] = 'Неправильный email';
			}
			if(!User::checkPassword($password)){
				$errors[] = 'Пароль не должен быть короче 6-ти символов';
			}

			
			// проверяем, существует ли пользователь
			$userId = User::checkUserData($email, $password);

			if($userId === false){
				$errors[] = 'Неправильне данные для входа на сайт';	
			} else {
				// если данные правильные, то запускаем процесс авторизации
				User::auth($userId);

				// Перенаправляем пользователя в закрытую часть - кабинет
				header("Location: /cabinet/");
			}
		}
		require_once(ROOT.'/views/user/login.php');
		return true;
	}

	/**
	 * Удаляем данные о пользователе из сессии, если он там был
	 */
	public function actionLogout()
	{
		unset($_SESSION['user']);
		header('Location: /');
	}

}

