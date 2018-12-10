<?php



class Product{

	const SHOW_BY_DEFAULT = 3;

	/**
	 * получаем список товаров
	 * работает универсально, на главную получает список последних товаров без пагинации
	 * на странице каталога получает все товары и разбивает на пагинацию
	 */
	public static function getLatestProducts($count = self::SHOW_BY_DEFAULT, $page = 1)
	{

		$count = intval($count);
		$page = intval($page);
		$offset = ($page - 1) * $count;

		$db = Db::getConnection();
		$productsList = array();

		$result = $db->query('SELECT id, name, price, is_new, image FROM product '
			. 'WHERE status = "1" '
			. 'ORDER BY id DESC ' 
			. 'LIMIT ' . $count
			. ' OFFSET '. $offset);

		$i = 0;
		while($row = $result->fetch()){
			$productsList[$i]['id'] = $row['id'];
			$productsList[$i]['name'] = $row['name'];
			$productsList[$i]['price'] = $row['price'];
			$productsList[$i]['is_new'] = $row['is_new'];
			$productsList[$i]['image'] = $row['image'];

			$i++;
		}
		return $productsList;
	}


	/**
	 * получаем список рекомендованных товаров
	 */
	public static function getRecommendProducts()
	{
		$productsList = array();

		$db = Db::getConnection();
		$result = $db->query('SELECT * FROM product WHERE status = "1" AND is_recommended = "1"');
		$result->setFetchMode(PDO::FETCH_ASSOC);

		$i = 0;
		while($row = $result->fetch()){
			$productsList[$i]['id'] = $row['id'];
			$productsList[$i]['name'] = $row['name'];
			$productsList[$i]['price'] = $row['price'];
			$productsList[$i]['image'] = $row['image'];

			$i++;
		}

		return $productsList;
	}

	

	/**
	 * получаем список товаров в определенной категории
	 */
	public static function getProductsListByCategory($category_id, $page = 1)
	{
		if($category_id){
			$page = intval($page);
			$offset = ($page - 1) * self::SHOW_BY_DEFAULT;

			$db = Db::getConnection();
			$categoryProducts = array();
	
			$result = $db->query('SELECT id, name, price, is_new, image FROM product '
				. 'WHERE status = "1" AND category_id = "'.$category_id.'" '
				. 'ORDER BY id DESC '
				. 'LIMIT ' . self::SHOW_BY_DEFAULT
				. ' OFFSET ' . $offset
			);
	
			$i = 0;
			while($row = $result->fetch()){
				$categoryProducts[$i]['id'] = $row['id'];
				$categoryProducts[$i]['name'] = $row['name'];
				$categoryProducts[$i]['price'] = $row['price'];
				$categoryProducts[$i]['is_new'] = $row['is_new'];
				$categoryProducts[$i]['image'] = $row['image'];
	
				$i++;
			}
			return $categoryProducts;
		}
	}



	/**
	 * получаем данные о товаре, для карточки товара
	 */
	public static function getProductById($product_id)
	{
		$product_id = intval($product_id);

		if($product_id){
			$db = Db::getConnection();
			$result = $db->query('SELECT * FROM product WHERE id=' . $product_id);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$product = $result->fetch();
			return $product;
		}

	}



	/**
	 * получаем количество товаров в определенной категории
	 */
	public static function getTotalProductsInCategory($category_id)
	{
		$db = Db::getConnection();

		$result = $db->query('SELECT count(id) AS count FROM product '
                . 'WHERE status="1" AND category_id ="'.$category_id.'"');
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}



	/**
	 * получаем количество товаров
	 */
	public static function getTotalProducts()
	{
		$db = Db::getConnection();
		$result = $db->query('SELECT count(id) AS count FROM product WHERE status="1"');
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}



	/**
	 * Получаем массив с товарами в корзине (полную информацию о каждом товаре)
	 */

	public static function getProductsByIds($productsIds)
	{
		$products = array();

		$db = Db::getConnection();

		$idsString = implode(',', $productsIds);

		$sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

		$result = $db->query($sql);
		$result->setFetchMode(PDO::FETCH_ASSOC);

		$i = 0;
		while($row = $result->fetch()){
			$products[$i]['id'] = $row['id'];
			$products[$i]['code'] = $row['code'];
			$products[$i]['price'] = $row['price'];
			$products[$i]['name'] = $row['name'];

			$i++;
		}

		return $products;
	}



	/**
	 * Получаем список всех товаров
	 * @return array массив с товарами
	 */
	public static function getProductsList()
	{
		$productsList = array();

		$db = Db::getConnection();

		$sql = "SELECT * FROM product WHERE status='1'";

		$result = $db->query($sql);
		$result->setFetchMode(PDO::FETCH_ASSOC);

		$i = 0;
		while($row = $result->fetch()){
			$productsList[$i]['id'] = $row['id'];
			$productsList[$i]['code'] = $row['code'];
			$productsList[$i]['price'] = $row['price'];
			$productsList[$i]['name'] = $row['name'];

			$i++;
		}

		return $productsList;
	}



	/**
	 * Удаляет товар с указанным id
	 * @param integer $id <p>id товара</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function deleteProductById($id)
	{
		$db = Db::getConnection();

		$sql = 'DELETE FROM product WHERE id= :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		return $result->execute();

	}



	/**
	 * Добавляет новый товар
	 * @param array $options <p>Массив с информацией о товаре</p>
	 * @return integer <p>id добавленной в таблицу записи(товара)</p>
	 */
	public static function createProduct($options)
	{

		$db = Db::getConnection();

		$sql = 'INSERT INTO product '
					. '(name, category_id, code, price, availability, brand, description, is_new, is_recommended, status)'
					. ' VALUES '
					. '(:name, :category_id, :code, :price, :availability, :brand, :description, :is_new, :is_recommended, :status)';

		// Получение и возврат результатов, используется подготовленный запрос
		$result = $db->prepare($sql);
		$result->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
		$result->bindParam(':code', $options['code'], PDO::PARAM_STR);
		$result->bindParam(':price', $options['price'], PDO::PARAM_STR);
		$result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
		$result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
		$result->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
		$result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);

		if($result->execute()){
			// Если запрос выполнен успешно, возвращаем id добавленной записи
			return $db->lastInsertId();
		}
		// Иначе возвращаем 0
		return 0;
	}



	/**
	 * Редактирует товар с заданным id
	 * @param integer $id <p>id товара</p>
	 * @param array $options <p>Массив с информацией о товаре</p>
	 * @return boolean <p>Результат выполнения метода</p>
	 */
	public static function updateProductById($id, $options)
	{
		$db = Db::getConnection();

		$sql = 'UPDATE product 
				SET
					name = :name,
					category_id = :category_id,
					code = :code,
					price = :price,
					availability = :availability,
					brand = :brand,
					description = :description,
					is_new = :is_new,
					is_recommended = :is_recommended,
					status = :status
				WHERE id = :id';

		$result = $db->prepare($sql);

		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->bindParam(':name', $options['name'], PDO::PARAM_STR);
		$result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
		$result->bindParam(':code', $options['code'], PDO::PARAM_STR);
		$result->bindParam(':price', $options['price'], PDO::PARAM_STR);
		$result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
		$result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
		$result->bindParam(':description', $options['description'], PDO::PARAM_STR);
		$result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
		$result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
		$result->bindParam(':status', $options['status'], PDO::PARAM_INT);
		
		return $result->execute();
	}


	/**
	 * Возвращает путь к изображени.
	 * @param integer $id
	 * $return string <p>Путь к изображению</p>
	 */
	public static function getImage($id)
	{	
		// Название изоюражения заглушки
		$noImage = 'no-image.jpg';

		// Путь к папке с товарами
		$path = '/template/images/tovars/';

		// Путь к изображению товара
		$pathToProductImage = $path . $id . '.jpg';

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)){
			// Если изображение для товара существует, возвращаем путь изображения товара
			return $pathToProductImage;
		}
		// Иначе возвращаем изображение заглушку
		return $path . $noImage;
	}

}