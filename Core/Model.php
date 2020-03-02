<?php

namespace Core;

use Base;
use Carbon\Carbon;

Abstract class Model
{
	/**
	 * Название таблицы
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Приватные данные, которые не дожны показываться, если их не запрашивают через SELECT ...
	 * Пример: $user->getAll(['password', 'token']); после чего они окажутся в ответе
	 *
	 * @var array
	 */
	protected $private = [];

	/**
	 * Данные, которые можно записать в базу без ограничений
	 * На подобии такого: $user->create($_POST); 
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * Данные в формате timestamp, которые будут выведены объектом Carbon
	 *
	 * @var array
	 */
	protected $timestamps = ['created_at', 'updated_at', 'deleted_at'];
	
	/**
	 * Получение всех данных или по лимиту
	 *
	 * @param  string|array $select
	 * @param  int $offset
	 * @param  false|int $limit
	 * @return false|array
	*/
	public function getAll($select = '*', $offset = 0, $limit = false)
	{
		$response = false;
		
		$limitQuery = ( !$limit ? '' : ' LIMIT '.$offset.','.$limit );
		
		$query = Base::query('SELECT '.$this->convertSelect($select).' FROM `'.$this->table.'`'.$limitQuery, [], 'arr');
		
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

	/**
	 * Получение данных по их id
	 *
	 * @param string|array $select
	 * @return false|array
	*/
	public function getById($id, $select = '*')
	{
		$response = false;
		
		if (!empty($id))
		{
			$query = Base::get($this->table, $id, false, $this->convertSelect($select));
			
			if (!empty($query))
			{
				$response = $this->checkFields($query, $select);
			}
		}
		return $response;
	}
	
	/**
	 * Получение первой записи
	 *
	 * @param string|array $select
	 * @return false|array
	*/
	public function first($select = '*')
	{
		$response = false;
		
		if ($array = $this->getAll($select))
		{
			$response = array_shift($array);
		}
		return $response;
	}
	
	/**
	 * Получение последней записи
	 * 
	 * @param  string|array $select
	 * @return false|array
	 */
	public function last($select = '*')
	{
		$response = false;
		
		if ($array = $this->getAll($select))
		{
			$array = array_reverse($array);
			
			$response = array_shift($array);
		}
		return $response;
	}
	
	/**
	 * Добавление новой записи
	 * 
	 * @param  array $params
	 * @return false|integer
	 */
	public function create($params)
	{
		$response = false;
		
		if (!empty($params))
		{
			$this->fillable($params);
			
			$query = Base::add($this->table, $params);
			
			if (!empty($query)) $response = $query;
		}
		return $response;
	}
	
	/**
	 * Обновление записи
	 * 
	 * @param  array $where
	 * @param  array $params
	 * @return false|array
	 */
	public function save($where, $params)
	{
		$response = false;
		
		if (!empty($params))
		{
			$this->fillable($params);
			
			$query = Base::update($this->table, $where, $params);
			
			if (!empty($query)) $response = $query;
		}
		return $response;
	}
	
	/**
	 * Удаление записи
	 * 
	 * @param  integer|array|string
	 * @return false
	 */
	public function delete($where)
	{
		$response = false;
		
		if (!empty($where))
		{
			$query = Base::remove($this->table, $where);
			
			if (!empty($query)) $response = $query;
		}
		return $response;
	}
	
	/**
	 * Проверка данных перед отдачей из функции
	 * Так же добавление timestamp ключам объекта Carbon
	 * 
	 * @param  array $array
	 * @param  string|array $select
	 * @return false|array
	 */
	protected function checkFields($array, $select)
	{
		$response = false;
		
		if (!empty($array))
		{
			Carbon::setLocale('ru');
			
			foreach($array as $key => $value)
			{
				if (in_array($key, $this->private))
				{
					if (!is_array($select) || !in_array($value, $select)) unset($array[$key]);
				}
				elseif (in_array($key, $this->timestamps))
				{
					$array[$key] = Carbon::parse($value);
				}
			}
			$response = $array;
		}
		return $response;
	}
	
	/**
	 * Проверка входных данных
	 * 
	 * @param  array
	 * @return false
	 */
	protected function fillable(&$params)
	{
		$response = false;
		
		if (!empty($this->fillable))
		{
			foreach($params as $key => $value)
			{
				if (!in_array($key, $this->fillable))
				{
					unset($params[$key]);
				}
			}
			$response = true;
		}
		return $response;
	}
	
	/**
	 * Конвертация select параметра под SQL запрос
	 * 
	 * @param  array|string
	 * @return string
	 */
	protected function convertSelect($select)
	{
		return (is_array($select) && !empty($select) ? implode(', ', $select) : '*');
	}
}
