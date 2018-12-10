<?php

// include_once ROOT. '/models/Category.php';	
// include_once ROOT. '/models/Product.php';	
// include_once ROOT. '/components/Pagination.php';	

class CatalogController {

	public function actionIndex($page = 1)
	{
		// список категорий для меню
		$categoriesList = Category::getCategoriesList();


		// список товаров
		/**
		 * первый параметр - количество товаров на одной странице, по умолчани
		 * второй праметр = номер страницы пагинации
		 */
		$listProducts = Product::getLatestProducts(6, $page);	


		// кол-во всех товаров
		$total = Product::getTotalProducts();
		$pagination = new Pagination($total, $page, 6, 'page-');


		require_once(ROOT . '/views/catalog/index.php');
		return true;
	}

	public function actionCategory($category_id, $page = 1)
	{
		// список категорий для меню
		$categoriesList = Category::getCategoriesList();


		// список товаров категории
		/**
		 * первый параметр - id категории из которой делать выборку товаров
		 * второй праметр = номер страницы пагинации
		 * количество товаров на одной странице - тут оно не передается, а берется из константы класса Product
		 */
		$categoryProducts = Product::getProductsListByCategory($category_id, $page);


		// постраничная пагинация
		/**
		 * $total - общее количество товаров в текущей категории
		 * $page - номер страницы
		 * третий параметр - Product::SHOW_BY_DEFAULT - количество товаров на странице
		 * четвертый параметр - ключ, который будет фигурировать в url
		 */
		$total = Product::getTotalProductsInCategory($category_id);
		$pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

		require_once(ROOT . '/views/catalog/category.php');
		return true;
	}

}