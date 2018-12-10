<?php



class CabinetController {


	public function actionIndex()
	{
		// получаем id пользователя из сессии, если нет в сессии то нарпявляем на страницу входа
		$userId = User::checkLogged();

		// получаем информацию о пользователе из БД
		$user = User::getUserById($userId);

		require_once(ROOT . '/views/cabinet/index.php');
		return true;
	}


	public function actionEdit()
	{
		// получаем id пользователя из сессии
		$userId = User::checkLogged();

		// получаем информацию о пользователе из БД (чтобы заполнить форму данными из бд)
		$user = User::getUserById($userId);

		$name = $user['name'];
		$password = $user['password'];

		$result = false;

		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$password = $_POST['password'];

			$errors = false;

			if(!User::checkName($name)){
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}

			if(!User::checkPassword($password)){
				$errors[] = 'Пароль не должен быть короче 6-ти символов';
			}


			if(!$errors){
				// обрабатываем форму дальше
				$result = User::edit($userId, $name, $password);
			}


		}

	
		require_once(ROOT. '/views/cabinet/edit.php');


		return true;
	}

}