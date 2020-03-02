<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
	/**
	 * Название таблицы
	 * 
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Приватные данные, которые не дожны показываться, если их не запрашивают через SELECT
	 * Типа: $user->getAll(['password', 'token']); после чего они окажутся в ответе
	 * 
	 * @var array
	 */
	protected $private = ['token', 'password'];

	/**
	 * Данные, которые можно записать в базу без ограничений
	 * На подобии такого: $user->create($_POST); 
	 * 
	 * @var array
	 */
	protected $fillable = ['login', 'email', 'password', 'first_name', 'last_name'];

	/**
	 * Данные в формате timestamp, которые будут выведены объектом Carbon
	 * 
	 * @var array
	 */
	protected $timestamps = ['created_at', 'updated_at', 'deleted_at'];
}
