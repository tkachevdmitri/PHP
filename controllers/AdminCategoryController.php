<?php

/**
 * Контроллер AdminCategoryController
 * Управление категориями в админпанели
 */


class AdminCategoryController extends AdminBase {

	/**
	 * Action для страницы "Управление категориями"
	 */
	public function actionIndex()
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем список категорий
		$categoriesList = Category::getCategoriesListAdmin();


		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_category/index.php'); 

		return true;
	}


	/**
	 * Action для страницы "Удалить категорию"
	 */
	public function actionDelete($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, удаляем товар
			Category::deleteCategoryById($id);

			// Перенаправляем пользователя на страницу управления товарами
			header("Location: /admin/category");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_category/delete.php');

		return true;
	}


	/**
	 * Action для страницы "Добавить категорию"
	 */
	public function actionCreate()
	{
		//echo 'actionCreate AdminProductController';
		// Проверка доступа
		self::checkAdmin();

		
		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, получаем данные из формы
			$options['name'] = $_POST['name'];
			$options['sort_order'] = $_POST['sort_order'];
			$options['status'] = $_POST['status'];

			$errors = false;

			// При необходимости можно валидировать значения полей
			if(!isset($options['name']) || empty($options['name'])){
				$errors[] = 'Запоните поля';
			}

			if($errors === false){
				// Если ошибок нет, добавляем новый товар
				$id = Category::createCategory($options);

				// Перенаправляем пользователя на страницу управления товарами
				header("Location: /admin/category");
			}
		}
		

		require_once(ROOT . '/views/admin_category/create.php');

		return true;
	}


	/**
	 * Action для страницы "Редактировать категорию"
	 */
	public function actionUpdate($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем данные о конкретном товаре
		$category = Category::getCategoryById($id);

		
		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, получаем данные из формы редактирования, при необходимости можно валидировать значения
			$options['name'] = $_POST['name'];
			$options['sort_order'] = $_POST['sort_order'];
			$options['status'] = $_POST['status'];

			// Сохраняем изменения
			Category::updateCategoryById($id, $options);

			// Перенаправляем пользователя на страницу управлениями товарами
			header("Location: /admin/category");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_category/update.php');
		return true;

	}




}
