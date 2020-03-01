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
	public $path = [ROOT.'/App/Views/'];
	public $factory;
	public $revolser;
	public $compiler;
	public $cachePath = ROOT.'/cache/blade/';
	
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
    
    public function compiler()
    {
        return $this->compiler;
    }
    
	public function render($view, $data = [])
	{
        return $this->factory->make($view, $data)->render();
	}
}
