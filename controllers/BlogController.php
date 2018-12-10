<?php

class BlogController {

	const SHOW_BY_DEFAULT = 3; // кол-во статей на одной странице

	public function actionList($page = 1)
	{

		// список категорий для меню сайдбара
		$categoriesList = Category::getCategoriesList();


		// список всех статей (для первой страницы пагинации)
		$listPublications = Blog::getPublicationsList(self::SHOW_BY_DEFAULT, $page);


		// кол-во всех статей
		$total = Blog::getTotalPublicationsList();
		$pagination = new Pagination($total, $page, self::SHOW_BY_DEFAULT, 'page-');

		require_once(ROOT . '/views/blog/index.php');
		return true;
	}


	public function actionView($publication_id)
	{

		// список категорий для меню сайдбара
		$categoriesList = Category::getCategoriesList();

		$itemPublication = Blog::getOneView($publication_id);

		require_once(ROOT . '/views/blog/publication.php');
		return true;
	}

}