<?php

namespace Core;

use Base;
use Carbon\Carbon;

Abstract class Model
{
	protected $table;
	protected $fillable = [];
	protected $private = [];
	protected $timestamps = ['created_at', 'updated_at', 'deleted_at'];
	
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
	
	public function first($select = '*')
	{
		$response = false;
		
		if ($array = $this->getAll($select))
		{
			$response = array_shift($array);
		}
		return $response;
	}
	
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
	
	protected function convertSelect($select)
	{
		return (is_array($select) && !empty($select) ? implode(', ', $select) : '*');
	}
}
