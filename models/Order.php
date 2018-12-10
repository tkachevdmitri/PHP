<?php


class Order {
	
	/**
	 * Сохранение заказа 
	 * @param type $name
	 * @param type $email
	 * @param type $password
	 * @return type
	 */
	public static function save($name, $phone, $comment, $userId, $products)
	{
		$products = json_encode($products);

		$db = Db::getConnection();

		$sql = 'INSERT INTO product_order (name, phone, comment, user_id, products) '
						. 'VALUES (:name, :phone, :comment, :user_id, :products)';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		$result->bindParam(':phone', $phone, PDO::PARAM_STR);
		$result->bindParam(':comment', $comment, PDO::PARAM_STR);
		$result->bindParam(':user_id', $userId, PDO::PARAM_STR);
		$result->bindParam(':products', $products, PDO::PARAM_STR);

		return $result->execute();
	}	



	/**
	 * Возвращает массив заказов для админпанели
	 * @return array <p>Массив с зазказами</p>
	 */
	public static function getOrdersListAdmin()
	{
		$ordersList = array();

		$db = Db::getConnection();
		$result = $db->query('SELECT * FROM product_order ORDER BY id ASC');

		$i = 0;
		while($row = $result->fetch()){
			$ordersList[$i]['id'] = $row['id'];
			$ordersList[$i]['name'] = $row['name'];
			$ordersList[$i]['phone'] = $row['phone'];
			$ordersList[$i]['date'] = $row['date'];
			$ordersList[$i]['status'] = $row['status'];
			$i++;
		}

		return $ordersList;

	}



	/**
	 * В зависимости от статуса возвращет строку с нужным значением
	 * @return string
	 */
	public static function getStatusText($status)
	{
		$status_variants = array( 1 => 'Новый заказ', 'В обработке', 'Доставляется', 'Отменен', 'Закрыт');
		return $status_variants[$status];
	}



	/**
	 * Удаляет заказ с указанным id
	 * @param integer $id <p>id заказа</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function deleteOrderById($id)
	{
		$db = Db::getConnection();

		$sql = 'DELETE FROM product_order WHERE id= :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		return $result->execute();

	}



	/**
	 * Возвращает массив с информацией о заказе
	 * @param integer $id <p>id заказа</p>
	 * @return array $order <p>массив с информацией о заказе</p>
	 */
	public static function getOrderById($id)
	{
		$orderId = intval($id);

		if($orderId){
			$db = Db::getConnection();
			$result = $db->query('SELECT * FROM product_order WHERE id="'.$orderId.'"');
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$order = $result->fetch();
			return $order;
		}
	}


	/**
	 * Редактирует заказ с заданным id
	 * @param integer $id <p>id заказа</p>
	 * @param array $options <p>Массив с информацией о заказе</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function updateOrderById($id, $options)
	{
		$db = Db::getConnection();

		$sql = 'UPDATE product_order 
				SET
					name = :name,
					phone = :phone,
					comment = :comment,
					status = :status
				WHERE id = :id';

		$result = $db->prepare($sql);

		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result->bindParam(':phone', $options['phone'], PDO::PARAM_STR);
		$result->bindParam(':comment', $options['comment'], PDO::PARAM_STR);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);
		
		return $result->execute();
	}



}