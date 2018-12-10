<?php


class Category {

	/**
	 * Возвращает массив категорий для списка на сайте
	 * @return array <p>Массив с категориями</p>
	 */
	public static function getCategoriesList()
	{
		// соединяемся с базой данных
		$db = Db::getConnection();

		$categoriesList = array();

		// формируем запрос и обрабатываем выборку
		$result = $db->query('SELECT id, name FROM category WHERE status = "1" ORDER BY sort_order ASC');

		$i = 0;
		while($row = $result->fetch()){
			$categoriesList[$i]['id'] = $row['id'];
			$categoriesList[$i]['name'] = $row['name'];

			$i++;
		}

		return $categoriesList;
	}



	/**
	 * Возвращает массив категорий для списка в админпанели
	 * при этом в результат попадают и выключенные категории
	 * @return array <p>Массив с категориями</p>
	 */
	public static function getCategoriesListAdmin()
	{
		$db = Db::getConnection();

		$categoriesList = array();

		$result = $db->query('SELECT * FROM category ORDER BY id ASC');

		$i = 0;
		while($row = $result->fetch()){
			$categoriesList[$i]['id'] = $row['id'];
			$categoriesList[$i]['name'] = $row['name'];
			$categoriesList[$i]['sort_order'] = $row['sort_order'];
			$categoriesList[$i]['status'] = $row['status'];
			$i++;
		}

		return $categoriesList;
	}


	/**
	 * В зависимости от статуса возвращет строку с нужным значением
	 * @return string
	 */
	public static function getStatusText($status)
	{
		$status_text = '';
		if($status){
			$status_text = 'Отображается';
		} else {
			$status_text = 'Скрыта';
		}
		return $status_text;
	}


	/**
	 * Удаляет категорию с указанным id
	 * @param integer $id <p>id категории</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function deleteCategoryById($id)
	{
		$db = Db::getConnection();

		$sql = 'DELETE FROM category WHERE id= :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		return $result->execute();

	}


	/**
	 * Добавляет новую категорию
	 * @param array $options <p>Массив с информацией о категории</p>
	 */
	public static function createCategory($options)
	{

		$db = Db::getConnection();

		$sql = 'INSERT INTO category '
					. '(name, sort_order, status)'
					. ' VALUES '
					. '(:name, :sort_order, :status)';

		// Получение и возврат результатов, используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result->bindParam(':sort_order', $options['sort_order'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);

		return $result->execute();
	}


	/**
	 * Возвращает массив с информацией о категории
	 * @param integer $id <p>id категории</p>
	 * @return array $category <p>массив с информацией о категории</p>
	 */
	public static function getCategoryById($id)
	{
		$categoryId = intval($id);

		if($categoryId){
			$db = Db::getConnection();
			$result = $db->query('SELECT * FROM category WHERE id="'.$categoryId.'"');
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$category = $result->fetch();
			return $category;
		}
	}


	/**
	 * Редактирует категорию с заданным id
	 * @param integer $id <p>id категории</p>
	 * @param array $options <p>Массив с информацией о категории</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function updateCategoryById($id, $options)
	{
		$db = Db::getConnection();

		$sql = 'UPDATE category 
				SET
					name = :name,
					sort_order = :sort_order,
					status = :status
				WHERE id = :id';

		$result = $db->prepare($sql);

		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result->bindParam(':sort_order', $options['sort_order'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);
		
		return $result->execute();
	}

}