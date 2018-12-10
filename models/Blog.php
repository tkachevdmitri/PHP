<?php


class Blog{

	const SHOW_BY_DEFAULT = 3;

	public static function getPublicationsList($count = self::SHOW_BY_DEFAULT, $page = 1)
	{

		$count = intval($count);
		$page = intval($page);
		$offset = ($page - 1) * $count;

		$db = Db::getConnection();
		$publicationList = array();

		$result = $db->query('SELECT * FROM publication '
			. 'WHERE published="1" '
			. 'LIMIT ' . $count
			. ' OFFSET ' . $offset);

		$i = 0;
		while($row = $result->fetch()){
			$publicationList[$i]['id'] = $row['id'];
			$publicationList[$i]['title'] = $row['title'];
			$publicationList[$i]['date'] = $row['date'];
			$publicationList[$i]['short_content'] = $row['short_content'];
			$publicationList[$i]['preview'] = $row['preview'];

			$i++;
		}

		return $publicationList;
	}


	public static function getTotalPublicationsList()
	{
		$db = Db::getConnection();
		$result = $db->query('SELECT count(id) AS count FROM publication WHERE published="1"');
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();
		
		return $row['count'];
	}


	public static function getOneView($id)
	{
		$id = intval($id);
		if($id){
			$db = Db::getConnection();

			$result = $db->query('SELECT * FROM publication WHERE id='.$id);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$publication = $result->fetch();

			return $publication;

		}
		return true;
	}


}