<?php

namespace Modules\Admin\Http\Controllers\Ssential;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdminSsentialFileController extends AdminSsentialController
{
    public function __beforeConstruct()
    {
        $this->setModel([
            'alias' => 'file',
            'class' => \App\Models\File::class,
            'validations' => [
                'item' => [
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'status' => 'required|string',
                ],
                'list' => [
                    'ids' => 'required|string',
                    'operation' => 'required|string',
                ]
            ],
        ]);
    }
    /**
     * Display a paging list of the resource.
     * 显示资源的分页列表
     * @param \Illuminate\Http\
     * @done 统计子类数量
     * @done 若存在 slug ，就模糊查询
     * @done 若存在 name ，就模糊查询
     * @return Renderable
     */
    public function index()
    {

        // if (request()->method() == 'POST')
        // $this->import(request()->merge(['meta_id' => request()->input('parent', 0)]));
        // $this->select_meta_page([
        //     '$withCount' => "children"
        // ]);
        // $query = \App\Models\Meta::withCount('children');

        // request()->whenFilled('slug', function ($input) use (&$query) {
        //     $query = $query->where('slug', 'like', "%$input%");
        // });
        // request()->whenFilled('name', function ($input) use (&$query) {
        //     $query = $query->where('name', 'like', "%$input%");
        // });
        // $query = $query
        //     ->whereIn('type', request()->filled('type') ? [request()->input('type')] : array_keys($this->getOption('meta.type', [])))
        //     ->whereIn('status', request()->filled('status') ? [request()->input('status')] : array_keys($this->getOption('meta.status', [])))
        //     ->where('parent', request()->input('parent', 0))
        //     ->whereNull('deleted_at')
        //     ->orderBy('order')
        //     ->orderByDesc('updated_at');
        // $this->setAttributeSql('select_meta_list', $query->toRawSql());
        return $this->view('ssential.file-table', [
            // 'paginator' => $query->paginate(20),
            'paginator' => select_page([
                '$model' => \App\Models\File::class,
                '$withCount' => ["relationships"],
                '$where' => [
                    ['parent', request()->input('parent', 0)],
                ],
                '$size' => request()->input('size', 20)
            ])
        ]);
    }
    public function beforeStore()
    {
        $item = $this->getModel('class')::find(request('id'));
        $item->append('content');
        dump($item);
        dump($item->content);
        $data = [];
        foreach ($item->content as $key => $values) {
            ['key' => $key, 'attributes' => $attributes] = parse_key($key);
            $key = Str::plural($key);
            if (!isset($data[$key])) $data[$key] = [];

            if (array_is_list($values)) {
                $data[$key] = array_merge(array_map(function ($item) use ($attributes) {
                    return array_merge($item, $attributes);
                }, $values), $data[$key]);
            } else {
                $data[$key][] = array_merge($values, $attributes);
            }
            // dump($values);
            // dump(upsert_item($values, config('models.alias.' . $key)));
        }
        dump($data);
        $return = upsert_relation_list($data);
        dd($return);

        dd(request()->all());
    }

    public function afterEdit($return)
    {
        if (isset($return['item'])) $return['item']->append('content');
        return $return;
    }

    /**
     * Update the specified resource in storage.
     * 更新存储中的指定资源。
     * @param 
     * @param int $id
     * @done 根据 ID 查询对应资源
     * @return Renderable
     */
    public function update($id)
    {
        // 验证表单
        $this->validata_item();

        // 绑定用户
        request()->merge([
            'user_id' => Auth::id(),
            'description' => request()->input('description', __METHOD__),
        ]);
        // 
        $meta = \App\Models\Meta::find($id);
        // 
        $meta->fill(request()->all());
        // 保存资源
        $meta->save();
        // 清除缓存
        if (in_array($meta->type, ['module'])) {
            Cache::forget("meta_modules");
        }
        return $this->edit($meta->id);
    }


    public function export() {}
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
