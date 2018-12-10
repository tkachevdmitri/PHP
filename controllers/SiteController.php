<?php

// include_once ROOT. '/models/Category.php';	
// include_once ROOT. '/models/Product.php';	

class SiteController {

	public function actionIndex()
	{
		// список категорий
		$categoriesList = Category::getCategoriesList();
		// последние товары
		$latestProducts = Product::getLatestProducts(3);	


		// рекомендуемые товары
		$recommendProducts = Product::getRecommendProducts();


		require_once(ROOT . '/views/site/index.php');
		return true;
	}


	public function actionContacts()
	{
		
		$userEmail = '';
		$userMessage = '';
		$result = false;

		if(isset($_POST['submit'])){

			$userEmail = $_POST['email'];
			$userMessage = $_POST['message'];

			$errors = false;


			if(!User::checkEmail($userEmail)){
				$errors[] = 'Неправильный email';
			}

			if(!$errors){
				// обрабатываем форму дальше
				$adminEmail = 'tkachevdmitri-web@mail.ru';
				$message = "Текст {$userMessage}. Отправил {$userEmail}";
				$subject = 'Тема письма';

				$result = mail($adminEmail, $subject, $message);
				$result = true;
			}


		}


		require_once(ROOT . '/views/site/contacts.php');
		return true;

	}

}