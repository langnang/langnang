<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class AdminRelationshipController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $return = [
            'meta_modules' => select_list([
                '$model' => \App\Models\Meta::class,
                '$with' => ['children'],
                '$where' => [['type', 'module'], ['parent', 0]],
                '$whereNotIn' => ['slug', ['admin']],
            ])
        ];
        request()->whenFilled('meta_id', function ($id) use (&$return) {
            $return['meta_id'] = $id;
            $return['item'] = $item = select_item([
                '$model' => \App\Models\Meta::class,
                '$with' => ['relationships', 'contents', 'links', 'files'],
                '$where' => [['id', $id]]
            ]);
        });
        request()->whenFilled('content_id', function ($id) use (&$return) {
            $return['content_id'] = $id;
            $return['item'] = $item = select_item([
                '$model' => \App\Models\Content::class,
                '$with' => ['relationships', 'metas', 'links', 'files'],
                '$where' => [['id', $id]]
            ]);
        });
        request()->whenFilled('link_id', function ($id)  use (&$return) {
            $return['link_id'] = $id;
            $return['item'] = $item = select_item([
                '$model' => \App\Models\Link::class,
                '$with' => ['relationships', 'metas', 'contents', 'files'],
                '$where' => [['id', $id]]
            ]);
        });
        request()->whenFilled('file_id', function ($id) use (&$return) {
            $return['file_id'] = $id;
            $return['item'] = $item = select_item([
                '$model' => \App\Models\File::class,
                '$with' => ['relationships', 'metas', 'contents', 'links',],
                '$where' => [['id', $id]]
            ]);
        });
        return $this->view('relationship', $return,);
    }
}
