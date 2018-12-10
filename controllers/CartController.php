<?php



class CartController{

	public function actionAdd($id)
	{
		// добавляем товар в корзину
		Cart::addProduct($id);

		// возвращаем пользователя на страницу
		$referer = $_SERVER['HTTP_REFERER'];
		header("Location: $referer");
	}


	public function actionDelete($id)
	{
		// Удалить товар из корзины
		Cart::deleteProduct($id);

		// Возвращаем пользователя на страницу
		header("Location: /cart");
	}


	public function actionAddAjax($id)
	{
		// добавляем товар в корзину
		echo Cart::addProduct($id);
		return true;
	}


	public function actionIndex()
	{

		// список категорий для меню
		$categoriesList = Category::getCategoriesList();

		$productsInCart = false;
		// Получим данные из корзины
		$productsInCart = Cart::getProducts();

		if ($productsInCart) {
			// Получаем массив с идентификаторами товаров из корзины
			$productsIds = array_keys($productsInCart);
			$products = Product::getProductsByIds($productsIds);

			// Получаем общую стоимость товаров
			$totalPrice = Cart::getTotalPrice($products);
		}


		require_once(ROOT.'/views/cart/index.php');
		return true;
	}



	public function actionCheckout()
	{

		// список категорий для меню
		$categoriesList = Category::getCategoriesList();


		// Статус успешного оформления заказа
		$result = false;
		
		if(isset($_POST['submit'])){
			// Форма отправлена

			// Считываем данные формы
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$comment = $_POST['comment'];


			// Валидация полей
			$errors = false;

			if(!User::checkName($name)){
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}


			if(!User::checkPhone($phone)){
				$errors[] = 'Неправильный телефон';
			}

			
			if($errors === false){
				// Форма заполнена корректно
				// Сохраняем заказа в БД

				// Собираем информацию о заказе
				$productsInCart = Cart::getProducts();
				if( User::isGuest()){
					$userId = false;
				} else {
					$userId = User::checkLogged();
				}


				// Сохраняем заказ в БД
				$result = Order::save($name, $phone, $comment, $userId, $productsInCart);

				if($result){
					// Отправляем администратору письмо о новом заказе
					$adminEmail = 'tkachevdmitri-web@mail.ru';
					$message = "Новый заказ";
					$subject = 'Новый заказ';

					$result = mail($adminEmail, $subject, $message);


					// Очищаем корзину
					Cart::clear();
				}

			} else {
				// Форма заполнена не корректно

				// Итоги: общая стоимость, количество товаров
				$productsInCart = Cart::getProducts();
				$productsIds = array_keys($productsInCart);
				$products = Product::getProductsByIds($productsIds);
				$totalPrice = Cart::getTotalPrice($products);
				$totalQuantity = Cart::countItems();

			}


		} else {
			// Форма не отправлена
			// Получаем данные из корзины
			$productsInCart = Cart::getProducts();

			// В корзине есть товары?
			if($productsInCart === false){
				// В корзине нет товаров
				// Отправляем пользователя на главную страницу
				header("Location: /");
			} else {
				// В корзине есть товары
					
				// Итоги: общая стоимость, количество товаров
				$productsIds = array_keys($productsInCart);
				$products = Product::getProductsByIds($productsIds);
				$totalPrice = Cart::getTotalPrice($products);
				$totalQuantity = Cart::countItems();


				$name = false;
				$phone = false;
				$comment = false;


				// Пользователь авторизирован?
				if(User::isGuest()){
					// нет, значения полей форм - пустые
				} else{
					// да, получаем информацию о пользователе из БД по id
					$userId = User::checkLogged();
					$user = User::getUserById($userId);

					// Подставляем в форму
					$name = $user['name'];
				}

			}


		}



		require(ROOT . '/views/cart/checkout.php');


		return true;
	}




}