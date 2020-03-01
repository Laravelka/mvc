<?php

namespace App\Models;

use Core\Model;
use Base;

class News extends Model
{
	protected $table = 'news';
	
	public function getAll($select = '*', $offset = 0, $limit = false)
	{
		$response = false;
		
		$limitQuery = ( !$limit ? '' : ' LIMIT '.$offset.','.$limit );
		
		$query = Base::query('SELECT '.$this->convertSelect($select).' FROM `'.$this->table.'` `n`, `users` `u` WHERE `u`.`id` = `n`.`user_id` '.$limitQuery, [], 'arr');
		
		if (!empty($query))
		{
			$newArray = [];
			foreach($query as $array)
			{
				$newArray[] = $this->checkFields($array, $select);
			}
			$response = $newArray;
		}
		return $response;
	}
}
