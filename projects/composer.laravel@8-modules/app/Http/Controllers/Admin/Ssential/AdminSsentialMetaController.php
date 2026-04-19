<?php

namespace App\Http\Controllers\Admin\Ssential;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdminSsentialMetaController extends AdminSsentialController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'meta',
            'class' => \App\Models\Meta::class,
            'validations' => [
                'item' => [
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'status' => 'required|string',
                ],
                'list' => [
                    '*.name' => 'required|string',
                    '*.type' => 'required|string',
                    '*.status' => 'required|string',
                ]
            ],
            'messages' => [
                '*.name.required' => 'The name field is required.',
                '*.type.required' => 'The type field is required.',
                '*.status.required' => 'The status field is required.',
            ],
        ]);
    }
    public function beforeEachStore($item)
    {
        request()->whenFilled('parent', function ($value) use (&$item) {
            $item['parent'] = $value;
        });
        request()->whenFilled('type', function ($value) use (&$item) {
            $item['type'] = $value;
        });
        request()->whenFilled('status', function ($value) use (&$item) {
            $item['status'] = $value;
        });
        return $item;
    }
    public function afterEachDestory($item)
    {
        \App\Models\Relationship::where('meta_id', $item->id)->delete();
        return $item;
    }

    public function list()
    {
        // $this->validate('list');
        request()->validate([
            'ids' => 'required|string',
            'operation' => 'required|string',
        ]);
        $ids = explode('|', request()->input('ids'));
        var_dump($ids);
        $return = [
            "list" => select_list([
                '$model' => \App\Models\Meta::class,
                '$whereIn' => $ids
            ]),
            "modules" => \App\Models\Meta::with([
                'children' => function ($query) {
                    $query->where('type', 'module');
                }
            ])->where('type', 'module')->where('parent', 0)->get(),
        ];

        return $this->view('ssential.meta-form', $return);
    }

    public function batch()
    {
        request()->validate([
            'ids' => 'required|string',
            'operation' => 'required|string',
        ]);
        $ids = explode('|', request()->input('ids'));
        $list = \App\Models\Meta::whereIn('id', $ids)->get();

        switch (request()->input('operation')) {
            case 'update':
            case 'copy':
            case 'delete':

                break;
            case 'remove':
                request()->whenFilled('module', function ($input) use (&$list) {
                    foreach ($list as $item) {
                        $item->fill(['parent' => $input]);
                        $item->save();
                    }
                });
                break;

            case 'export-json':
                $path = 'metas/' . date_format(now(), 'Y_m_d_H_i_s_ms') . '_metas.json';
                Storage::put($path, json_encode(["metas" => $list], JSON_UNESCAPED_UNICODE));
                // return response()->download(\Storage::path($path), basename($path), ['content-type' => 'application/json']);

                return Storage::download($path, basename($path));
                break;
            case 'export-csv':
            case 'export-xlsx':
            case 'export-pdf':
                break;
            default:
                break;
        }

        // var_dump(request()->all());
        return $this->list();
        // $file = request()->file('file');
        // var_dump($file);

        // return $this->index();
    }
}
