<?php

namespace Modules\Admin\Http\Controllers\Helper;

use Illuminate\Support\Facades\Artisan;


class AdminHelperArtisanController extends AdminHelperController
{
    public function index()
    {
        Artisan::call('list');
        $return = [
            '$dir' => __DIR__,
            '$file' => __FILE__,
            '$line' => __LINE__,
            '$method' => __METHOD__,
            '$function' => __FUNCTION__,
            '$class' => static::class,
            '$request' => request()->all(),
            'artisan_list' => Artisan::output(),
            // 'commands' => preg_split("/\\n/", Artisan::output()),
        ];
        // $return['artisan_list'] = preg_replace(['/ /'], ['&nbsp;'], $return['artisan_list']);
        $return['commands'] = array_map(function ($item) {
            $res = [
                "command" => preg_replace(['/ /'], ['&nbsp;'], $item),
                "is_group" => false,
                "is_category" => false,
                "signature" => "",
                "description" => "",
            ];
            if (substr($item, 0, 2) === '  ') {
                $res['signature'] = substr($item, 2, strripos($item, '  '));
                $res['description'] = empty($res['signature']) ? $item : substr($item, strripos($item, '  ') + 2);
            } else if (substr($item, 0, 1) === ' ') {
                $res["is_category"] = true;
            } else {
                $res["is_group"] = true;
            }
            return $res;
        }, preg_split("/\\n/", $return['artisan_list']));
        // var_dump($return['commands']);
        // var_dump($return['commands']);
        // var_dump(preg_split("/\\n/", $return['commands'], ));
        // explode("\n", Artisan::output())
        // var_dump($return);
        return $this->view('helper.artisan', $return);
    }
}
