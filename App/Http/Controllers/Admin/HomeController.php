<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Core\Controller;
use App\Models\{News, User};
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends Controller
{
	public function index(ServerRequestInterface $request, $args) : ResponseInterface
	{
		return response()->view('admin.index');
	}
	
	public function files(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$currentDir = (
			!empty($request->getQueryParams()['path']) ? (
				substr($request->getQueryParams()['path'], -1) == DS ? $request->getQueryParams()['path'] : $request->getQueryParams()['path'].DS
			) : DS
		);
		$dir = ROOT.$currentDir;
		$files = [];
		
		if ($dirData = opendir($dir))
		{
			Carbon::setLocale('ru');
			
			while (($file = readdir($dirData)) !== false)
			{
				$realPath = $dir.$file;
				
				$isDir = is_dir($realPath);
				$fileSize = filesize($realPath);
				$fileType = filetype($realPath);
				$fileTime = filectime($realPath);
				
				if (!$isDir)
				{
					$exploding = explode('.', $file);
					$mimeType = strtolower(array_pop($exploding));
				}
				
				if ($file != '.' && $file != '..')
				{
					$files[$fileTime]['icon'] = (
						$isDir ? '/img/icons/folder.png' : (
							$mimeType == 'js' ? '/img/icons/javascript.png' : (
								file_exists(ROOT.'/public/img/icons/'.$mimeType.'.png') ? (
									'/img/icons/'.$mimeType.'.png'
								) : '/img/icons/file.png'
							)
						)
					);
					$files[$fileTime]['time'] = Carbon::parse($fileTime);
					$files[$fileTime]['size'] = $fileSize;
					$files[$fileTime]['type'] = $fileType;
					$files[$fileTime]['name'] = $file;
					$files[$fileTime]['path'] = $currentDir != '/' ? (
						$currentDir.'/'.$file
					) : '/'.$file;
				}
			}
			closedir($dirData);
			
			sort($files);
			
			$data = [
				'files' => $files
			];
		}
		return response($data)->view('admin.files');
	}
}
