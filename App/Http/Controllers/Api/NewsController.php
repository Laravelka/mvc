<?php

namespace App\Http\Controllers\Api;

use Core\Controller;
use App\Models\News;

class NewsController extends Controller
{
	public function all()
	{
		$news = new News;
		
		$data = [
			'allNews' => $news->getAll()
		];
		return response($data)->json();
	}
	
	public function getById($id)
	{
		$response = [];
		$news = new News;
		
		$data = $news->getById($id);
		
		if (empty($data))
		{
			$response = [
				'error' => true,
				'message' => 'Новость не найдена.'
			];
		}
		else
		{
			$response = [
				'data' => $data
			];
		}
		return response($response)->json();
	}
}
