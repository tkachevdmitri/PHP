<?php

/**
 * Контроллер AdminProductController
 * Управление товарами в админпанели
 */

class AdminProductController extends AdminBase {

	/**
	 * Action для страницы "Управление товарами"
	 */
	public function actionIndex()
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем список товаров
		$productsList = Product::getProductsList();

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_product/index.php');

		return true;
	}


	
	/**
	 * Action для страницы "Удалить товар"
	 */
	public function actionDelete($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, удаляем товар
			Product::deleteProductById($id);

			// Перенаправляем пользователя на страницу управления товарами
			header("Location: /admin/product");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_product/delete.php');

		return true;
	}



	/**
	 * Action для страницы "Добавить товар"
	 */
	public function actionCreate()
	{
		//echo 'actionCreate AdminProductController';
		// Проверка доступа
		self::checkAdmin();

		// список категорий для выпадающего списка
		$categoriesList = Category::getCategoriesListAdmin();

		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, получаем данные из формы
			$options['name'] = $_POST['name'];
			$options['category_id'] = $_POST['category_id'];
			$options['code'] = $_POST['code'];
			$options['price'] = $_POST['price'];
			$options['availability'] = $_POST['availability'];
			$options['brand'] = $_POST['brand'];
			$options['description'] = $_POST['description'];
			$options['is_new'] = $_POST['is_new'];
			$options['is_recommended'] = $_POST['is_recommended'];
			$options['status'] = $_POST['status'];

			$errors = false;

			// При необходимости можно валидировать значения полей
			if(!isset($options['name']) || empty($options['name'])){
				$errors[] = 'Запоните поля';
			}

			if($errors === false){
				/*
				 чтобы добавить изображение в поле БД
				if(is_uploaded_file($_FILES["image"]["tmp_name"])){
					// Если загружалось, переместим его в нужную папку, дадим новое имя
					move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/template/images/tovars/" . $_FILES["image"]["name"]);
					$img = "/template/images/tovars/" . $_FILES["image"]["name"];
				}	else {
					$img = "/template/images/tovars/no-image.jpg";
				}
				$options['image'] = $img;
				*/


				// Если ошибок нет, добавляем новый товар
				$id = Product::createProduct($options);
				
				// Если запись добавлена
				if($id) {
					// Проверим, загружалось ли фото
					if(is_uploaded_file($_FILES["image"]["tmp_name"])){
						echo 'загружалось';
						// Если загружалось, переместим его в нужную папку, дадим новое имя
						move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/template/images/tovars/{$id}.jpg");
					}
				}

				// Перенаправляем пользователя на страницу управления товарами
				header("Location: /admin/product");
			}
		}

		require_once(ROOT . '/views/admin_product/create.php');

		return true;
	}

	

	/**
	 * Action для страницы "Редактировать товар"
	 */
	public function actionUpdate($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// список категорий для выпадающего списка
		$categoriesList = Category::getCategoriesListAdmin();

		// Получаем данные о конкретном товаре
		$product = Product::getProductById($id);

		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, получаем данные из формы редактирования, при необходимости можно валидировать значения
			$options['name'] = $_POST['name'];
			$options['category_id'] = $_POST['category_id'];
			$options['code'] = $_POST['code'];
			$options['price'] = $_POST['price'];
			$options['availability'] = $_POST['availability'];
			$options['brand'] = $_POST['brand'];
			$options['description'] = $_POST['description'];
			$options['is_new'] = $_POST['is_new'];
			$options['is_recommended'] = $_POST['is_recommended'];
			$options['status'] = $_POST['status'];

			// Сохраняем изменения
			if(Product::updateProductById($id, $options)){
				// Если запись сохранена
				// Проверим, загружалось ли изображение
				if(is_uploaded_file($_FILES["image"]["tmp_name"])){
					// Если загружалось, переместим его в нужную папку, дадим новое имя
					move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/template/images/tovars/{$id}.jpg");
				}
			}

			// Перенаправляем пользователя на страницу управлениями товарами
			header("Location: /admin/product");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_product/update.php');
		return true;

	}




}