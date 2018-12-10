<?php

// include_once ROOT.'/models/Category.php';
// include_once ROOT.'/models/Product.php';

class ProductController{


	public function actionView($product_id)
	{	
		// список категорий
		$categoriesList = Category::getCategoriesList();

		// товар
		$product = Product::getProductById($product_id);

		require_once(ROOT . '/views/product/view.php');
		return true;
	}


}