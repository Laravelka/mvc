<?php

namespace Core;

class Error
{
	public static function errorHandler($level, $message, $file, $line)
	{
		if (error_reporting() !== 0)
		{
			throw new \ErrorException($message, 0, $level, $file, $line);
		}
	}
	
	public static function exceptionHandler($exception)
	{
        $code = !empty($exception->getCode()) ? $exception->getCode() : 400;
        
        if (get_class($exception) == 'League\Route\Http\Exception\NotFoundException')
        {
            $code = 404;
        }
		$file = dirname(__DIR__) . '/logs/php-'.date('Y-m-d').'.log';
		
		ini_set('error_log', $file);
		
		$message = "Uncaught exception: '" . get_class($exception) . "'";
		$message .= " with message '" . $exception->getMessage() . "'";
		$message .= "\nStack trace: " . $exception->getTraceAsString();
		$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
		
		error_log($message);
        
        $content = file_get_contents($exception->getFile());
        $lineCode = explode("\n", $content)[$exception->getLine()];
        
        exit(
            view('errors.all', [
                'http' => $code,
                'code' => $lineCode,
                'message' => $message
            ])
        );
	}
}
