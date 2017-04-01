<?php
/**
 * Created by PhpStorm.
 * User: ssd
 * Date: 2/12/17
 * Time: 8:26 AM
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseAdminController\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
    }
    public function checkVersion(Request $request){
        sleep(5);
        $platform = $request->get('platform');
        $requestVersion = $request->get('version');
        $response = array();
        $isSupport = false;
        $data = DB::table('support_version')->where([['active','=','1'],['platform_id','=',$platform]])->get();
        if(count($data)> 0){
            $versionArray = explode(";",$data[0]['version']);
            foreach ($versionArray as $value){
                    if($value == $requestVersion) {
                        $isSupport = true;
                        break;
                    }
            }
            $response['is_support'] = $isSupport;
            $response['link_update'] = "";
            $response['message_update'] = "";
            if(!$isSupport){
                $response['link_update'] = $data[0]['link_update'];
                $response['message_update'] = $data[0]['message_update'];
            }
        }
        return response(json_encode($response),200);

    }
    public function checkInfo(){
        echo phpinfo();
        // Connection constants
        define('MEMCACHED_HOST', '112.213.89.82');
        define('MEMCACHED_PORT', '11211');

// Connection creation
        $memcache = new \Memcache;
        $cacheAvailable = $memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);
        var_dump($cacheAvailable);
        exit;
    }
}