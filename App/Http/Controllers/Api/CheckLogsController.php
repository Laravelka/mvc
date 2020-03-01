<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Core\Controller;
use Core\Helpers\Request;

class CheckLogsController extends Controller
{
    public function wate()
    {
        session_write_close();
        ignore_user_abort(false);
        set_time_limit(40);
        
        try {
            // lastUpdate cookie saves the file update time which was sent to the browser
            if (!isset($_COOKIE['lastUpdate'])) {
                setcookie('lastUpdate', '0');
                $_COOKIE['lastUpdate'] = '0';
            }
            $lastUpdate = intval($_COOKIE['lastUpdate']);
            $file = ROOT.'/logs/php-'.date('Y-m-d').'.log';
            if (!file_exists($file)) {
                throw new \Exception($file.' Does not exist');
            }
            while (true) {
                $fileModifyTime = filemtime($file);
                if ($fileModifyTime === false) {
                    throw new \Exception('Could not read last modification time');
                }
                // if the last modification time of the file is greater than the last update sent to the browser... 
                if ($fileModifyTime > $lastUpdate) {
                    setcookie('lastUpdate', ''.$fileModifyTime.'');
                    // get file contents
                    $fileRead = file_get_contents($file);
                    
                    return response([
                        'status' => true,
                        'time' => $fileModifyTime, 
                        'content' => $fileRead
                    ])->json();
                }
                // to clear cache
                clearstatcache();
                // to sleep
                sleep(1);
            }
        } catch (\Exception $e) {
            return response(['status' => false,'error' => $e -> getMessage()])->json();
        }
    }
}