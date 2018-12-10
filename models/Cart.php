<?php


class Cart{

	public static function addProduct($id)
	{
		
		$id = intval($id);

		// Пустой массив для товаров в корзине
		$productsInCart = array();

		// Если в корзине уже есть товары (они хранятся в сессии)
		if(isset($_SESSION['products'])){
			// то заполним массив товарами
			$productsInCart = $_SESSION['products'];
		}


		// Если товар есть в корзине, но был добавлен еще раз, увеличим кол-во
		if(array_key_exists($id, $productsInCart)){
			$productsInCart[$id]++;
		} else {
			$productsInCart[$id] = 1;
		}


		$_SESSION['products'] = $productsInCart;

		return self::countItems();
	}

	/**
	 * Удаление товара из корзины
	 */
	public static function deleteProduct($id)
	{
		$id = intval($id);
		if (isset($_SESSION['products'][$id])){
			unset($_SESSION['products'][$id]);
		}
		//unset($_SESSION['products'][$id]);
	}


	/**
	 * Подсчет количества товаров в корзине (в сессии)
	 * @return int
	 */
	public static function countItems()
	{
		if(isset($_SESSION['products'])){
			$count = 0;

			foreach($_SESSION['products'] as $id => $quantity){
				$count += $quantity;
			}
			return $count;
		} else {
			return 0;
		}
	}



	/**
	 * получаем массив товаров из сессии
	 * @return array 
	 */
	public static function getProducts()
	{
		if(isset($_SESSION['products'])){
			return $_SESSION['products'];
		}

		return false;
	}


	/**
	 * Получаем общую стоимость товаров
	 */

	public static function getTotalPrice($products)
	{
		$productsInCart = self::getProducts();

		$total = 0;

		if($productsInCart){
			foreach($products as $item){
				$total += $item['price'] * $productsInCart[$item['id']];
			}
		}

		return $total;

	}




	/**
	 * Очищаем корзину
	 */
	public static function clear()
	{
		if(isset($_SESSION['products'])){
			unset($_SESSION['products']);
		}
	}


}