<?php

namespace App\Http\Controllers\Admin\Ssential;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use phpspider\core\requests;
use phpspider\core\selector;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Route;

class AdminSsentialContentController extends AdminSsentialController
{
    public function __afterConstruct()
    {
        $this->setModel([
            'alias' => 'content',
            'class' => \App\Models\Content::class,
            'validations' => [
                'item' => [
                    'title' => 'required|string',
                    'type' => 'required|string',
                    'status' => 'required|string',
                ]
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $return = $this->getReturn();

        $return['meta_modules'] = $meta_modules = $return['meta_modules'] ?? select_list([
            '$model' => \App\Models\Meta::class,
            '$where' => [
                ['type', 'module'],
                ['parent', request()->input('parent', 0)]
            ],
            '$orderBy' => ['order', 'desc'],
        ]);

        $this->mergeReturn($return);
        return parent::{__FUNCTION__}();

        // \DB::enableQueryLog();
        // \DB::flushQueryLog();
        // $paginator = $this->getModel('content')::with([
        //     'relationships',
        //     'belongsToMeta'
        // ])->whereHas('belongsToMeta', function ($query) {
        //     $query->where('meta_id', $this->getAttribute('id'));
        // })->withCount('children')
        //     ->where('slug', 'like', '%' . request()->input('slug') . '%')
        //     ->where('title', 'like', '%' . request()->input('title') . '%')
        //     ->whereIn('type', request()->filled('type') ? [request()->input('type')] : array_keys($this->getOption('content.type')))
        //     ->whereIn('status', request()->filled('status') ? [request()->input('status')] : array_keys($this->getOption('content.status')))
        //     ->where('parent', request()->input('parent', 0))
        //     ->whereNull('deleted_at')
        //     ->orderByDesc('updated_at')
        //     ->paginate(20);

        // $this->setAttributeSql('select_content_list', \DB::getQueryLog());
        // \DB::disableQueryLog();
        return $this->view('ssential.content-table', [
            'paginator' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['relationships', 'belongsToMeta'],
                '$withCount' => ["children", "relationships"],
                '$where' => [
                    ['slug', 'like', '%' . request()->input('slug') . '%'],
                    ['title', 'like', '%' . request()->input('title') . '%'],
                    ['parent', request()->input('parent', 0)]
                ],
                '$whereNull' => ['deleted_at'],
                '$orderByDesc' => 'updated_at',
                '$size' => 20
            ]),
            'meta_modules' => select_list([
                '$model' => \App\Models\Meta::class,
                '$where' => [
                    ['type', 'module'],
                    ['parent', request()->input('parent', 0)]
                ],
                '$orderBy' => ['order', 'desc'],
                '$size' => 20
            ]),
        ]);
    }

    // public function afterFactoryWithList($list) {}

    // public function afterEachFactoryWithList($item) {}

    public function afterFactoryWithItem($item)
    {
        // dd(__METHOD__);
        request()->whenFilled('spider', function ($url) use (&$item) {
            // $response = \Http::get($value);
            $html = requests::get($url);
            $parsed_url = parse_url($url);
            $item->slug = str_replace([':', '//', '/'], '-', $parsed_url['host'] . '-' . $parsed_url['path']);
            $title_selector = "//head//title";
            $item->title = $title = selector::select($html, $title_selector);
            $description_selector  = "//head//meta[@name='description']/@content";
            $item->description = $description = selector::select($html, $description_selector);
            $keywords_selector = "//head//meta[@rel='keywords']/@content";
            $item->keywords = $keywords = selector::select($html, $keywords_selector);
            $ico_selector = $ico = "//head//link[@rel='icon']/@href";
            $item->ico = selector::select($html, $ico_selector);
            if (is_array($item->ico)) $item->ico = $item->ico[sizeof($item->ico) - 1];
            if (Str::startsWith($item->ico, '/')) {
                $parsed_url['path'] = $item->ico;
                $item->ico = unparse_url($parsed_url);
            }
            $text_selector = "//body";
            $item->text = "----\ncreated: " . date('Y-m-d h:i:s.B') . "\ntags: [{$keywords}]\nsource: {$url}\nauthor: Spider\n----\n\n" . html_to_markdown(selector::select($html, $text_selector));
            // dd(html_to_markdown($html));
            // dd($html);
            // dd($value);
        });
        return $item;
    }
    public function afterEachStore($item)
    {
        $meta_module_id = null;
        if (request()->filled('module')) {
            $meta_module_id = request()->input('module');
        } else if ($item['module']) {
            $meta_module_id = $item['module'];
        }

        if ($meta_module_id) {
            \App\Models\Relationship::updateOrInsert(
                [
                    'meta_id' => $meta_module_id,
                    'content_id' => $item->id
                ],
                [],
            );
        }
        return $item;
    }
    public function afterEachUpdate($item)
    {
        $meta_module_id = null;
        if (request()->filled('module')) {
            $meta_module_id = request()->input('module');
        } else if ($item['module']) {
            $meta_module_id = $item['module'];
        }

        if ($meta_module_id) {
            \App\Models\Relationship::updateOrInsert(
                [
                    'meta_id' => $meta_module_id,
                    'content_id' => $item->id
                ],
                [],
            );
        }
        return $item;
    }
}
