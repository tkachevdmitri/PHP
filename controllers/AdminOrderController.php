<?php


/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */


class AdminOrderController extends AdminBase {

	/**
	 * Action для страницы "Управление заказами"
	 */
	public function actionIndex()
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем список заказов
		$ordersList = Order::getOrdersListAdmin();

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_order/index.php');

		return true;
	}



	/**
	 * Action для страницы "Удалить заказ"
	 */
	public function actionDelete($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, удаляем товар
			Order::deleteOrderById($id);

			// Перенаправляем пользователя на страницу управления товарами
			header("Location: /admin/order");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_order/delete.php');

		return true;
	}



	/**
	 * Action для страницы "Редактировать заказ"
	 */
	public function actionUpdate($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем данные о конкретном заказе
		$order = Order::getOrderById($id);

		
		// Обработка формы
		if(isset($_POST['submit'])){
			// Если форма отправлена, получаем данные из формы редактирования, при необходимости можно валидировать значения
			$options['name'] = $_POST['name'];
			$options['phone'] = $_POST['phone'];
			$options['comment'] = $_POST['comment'];
			$options['status'] = $_POST['status'];

			// Сохраняем изменения
			Order::updateOrderById($id, $options);

			// Перенаправляем пользователя на страницу управлениями товарами
			header("Location: /admin/order");
		}

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_order/update.php');
		return true;

	}




	/**
	 * Action для страницы "Просмотр заказа"
	 */
	public function actionView($id)
	{
		// Проверка доступа
		self::checkAdmin();

		// Получаем данные о конкретном заказе
		$order = Order::getOrderById($id);

		// Получаем массив с id и кол-м товаров
		$productsQuantity = json_decode($order['products'], true);

		// Получаем массив с индентификаторами товаров
		$productsIds = array_keys($productsQuantity);

		// Получаем список товаров в заказе
		$products = Product::getProductsByIds($productsIds);

		// Подключаем view для отображения
		require_once(ROOT . '/views/admin_order/view.php');

		return true;

	}


}