<?php

namespace Core;

use Xiaoler\Blade\FileViewFinder;
use Xiaoler\Blade\Factory;
use Xiaoler\Blade\Compilers\BladeCompiler;
use Xiaoler\Blade\Engines\CompilerEngine;
use Xiaoler\Blade\Filesystem;
use Xiaoler\Blade\Engines\EngineResolver;

class View
{
	/**
	 * Папка хранения шаблонов
	 * @var array
	 */
	public $path = [ROOT.'/App/Views/'];

	/**
	 * Экземпляр класса Factory
	 * @var Xiaoler\Blade\Factory
	 */
	public $factory;

	/**
	 * Экземпляр класса EngineRevolser
	 * @var Xiaoler\Blade\Engines\EngineResolver
	 */
	public $revolser;

	/**
	 * Экземпляр класса CompilerEngine
	 * @var Xiaoler\Blade\Engines\CompilerEngine
	 */
	public $compiler;

	/**
	 * Путь до папки кеша blade
	 * @var string
	 */
	public $cachePath = ROOT.'/cache/blade/';
	
	/**
	 * Иницилизация Blade
	 * 
	 * @return void
	 */
	public function __construct()
	{
		if (empty($this->path)) $this->path = [config('app.view.path')];
		if (empty($this->cachePath)) $this->cachePath = config('app.view.cachePath');
		
		$this->file = new Filesystem;
		$this->compiler = new BladeCompiler($this->file, $this->cachePath);

		$compiler = $this->compiler;

		$this->resolver = new EngineResolver;

		$this->resolver->register('blade', function () use ($compiler) {
		    return new CompilerEngine($compiler);
		});

		$this->factory = new Factory($this->resolver, new FileViewFinder($this->file, $this->path));
	}

	/**
	 * Рендер шаблона
	 * 
	 * @param  string
	 * @param  array
	 * @return string
	 */
	public function render(string $view, array $data = [])
	{
		return $this->factory->make($view, $data)->render();
	}
}
