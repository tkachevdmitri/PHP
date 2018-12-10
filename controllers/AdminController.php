<?php

/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */
class AdminController extends AdminBase {


	/**
	 * Action для главной страницы "Панель администратора"
	 */
	public function actionIndex()
	{
		// Проверка доступа
		self::checkAdmin();

		// Подключаем view
		require_once(ROOT . '/views/admin/index.php');

		return true;
	}



}