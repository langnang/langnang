<?php

namespace App\Http\Controllers\Admin\Ssential;

use App\Support\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AdminSsentialController extends \Modules\Admin\Http\Controllers\AdminController
{
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
        $this->_call(__FUNCTION__, 'before',);
        $return = $this->getReturn();

        $_where = [
            ['parent', request()->input('parent', 0)],
        ];
        request()->whenFilled('name', function ($value) use (&$_where) {
            $_where[] = ['name', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('title', function ($value) use (&$_where) {
            $_where[] = ['title', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('slug', function ($value) use (&$_where) {
            $_where[] = ['slug', 'like', '%' . $value . '%'];
        });
        request()->whenFilled('type', function ($value) use (&$_where) {
            $_where[] = ['type', $value];
        });
        request()->whenFilled('status', function ($value) use (&$_where) {
            $_where[] = ['status', $value];
        });

        $return['paginator'] = $paginator = $return['paginator'] ?? select_page([
            '$model' => request()->input('$model', $this->getModel('class')),
            '$withCount' => ["children", "relationships"],
            '$where' => $_where,
            '$whereNull' => 'deleted_at',
            '$orderBy' => 'order',
            '$orderByDesc' => 'updated_at',
            '$size' => request()->input('$size', 15),
        ]);

        $return = $this->_call(__FUNCTION__, 'after', $return);
        $this->mergeReturn($return);
        $view = Arr::get($return, 'view', 'ssential.' . $this->getModel('alias') . '-table');
        return $this->view($view, $return);
    }
    /**
     * Show the form for creating a new resource.
     * 显示用于创建新资源的表单
     * @param \Illuminate\Http\
     * @done 根据请求中数据创建新资源
     * @return Renderable
     */
    public function create()
    {
        $this->_call(__FUNCTION__, 'before',);

        $num = request()->input('num', 1);

        $list = [];
        while ($num > 0) {
            $list[] = $this->getModel('class')::make(request()->all());
            $num--;
        }
        sizeof($list) == 1 ? $return['item'] = $list[0] : $return['list'] = $list;
        $return = $this->_call(__FUNCTION__, 'after', $return);
        return $this->view('ssential.' . $this->getModel('alias') . '-form', $return);
    }
    /**
     * Show the form for creating a new resource that has been populated with factory
     * 显示用于创建已用模型工厂填充的新资源的表单
     * @param \Illuminate\Http\
     * @done 使用模型工厂创建新资源
     * @done 根据请求中数据替换新资源中对应数据
     * @return Renderable
     */
    public function factory()
    {
        // beforeFactory
        $this->_call(__FUNCTION__, 'before',);

        $num = request()->input('num', 1);

        $list = $this->getModel('class')::factory($num)->make([
            'parent' => request()->input('parent', 0),
            'count' => request()->input('parent', 0),
            'order' => request()->input('parent', 0),
            'template' => request()->input('parent', 0),
        ]);
        $num == 1
            ? $return['item'] = $item = $list->first()
            : $return['list'] = $list;

        // afterFactory($return)
        $return = $this->_call(__FUNCTION__, 'after', $return);
        // afterFactoryWithItem($item)
        // afterFactoryWithList($list)
        $return = $this->_callWith('afterFactory', $return, 'list', 'item');
        return $this->view('ssential.' . $this->getModel('alias') . '-form', $return);
    }
    /**
     * Store a newly created resource in storage.
     * 将新创建的资源存储在存储器中。
     * @param 
     * @done 2025-01-09 10:10:17 验证表单
     * @done 2025-01-09 10:10:17 绑定用户
     * @done 2025-01-09 10:10:17 重定向
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // beforeStore
        $this->_call(__FUNCTION__, 'before',);

        $return = [];
        $num = request()->input('num', 1);
        $list = request()->input('list', [request()->all()]);
        $ids = [];

        if ($num == 1 && $validated = $this->validate($list[0], 'item')) return $validated;
        if ($num > 1 && $validated = $this->validate($list, 'list')) return $validated;

        if ($validated = $this->_call(__FUNCTION__, 'valid',)) return $validated;

        foreach ($list as $item) {
            // dump($item);
            // beforeEachStore($item)
            $item = $this->_call(__FUNCTION__, 'beforeEach', $item);

            $validator = $this->validateModel($item, 'item');
            // dump($validator);
            if ($validator->fails()) {
                dump($validator);
                return back()->withErrors($validator)->withInput();
                // dd($validator->errors($validator));
                // throw new \RuntimeException($validator->errors()->first());
                // return redirect('post/create')
                //     ->withErrors($validator)
                //     ->withInput();
                // dump($validator->validated());
                // dump($validator->safe());
                // dd($validator->fails());
            }
            // dd($validator);
            $item = $this->getModel('class')::make($item);
            $item->save();
            if (empty($item->slug)) {
                // 2025-01-09 14:11:33 若标识为空，则默认为 ID
                $item->slug = $item->id;
                $item->save();
            }
            // afterEachStore($item) 
            $item = $this->_call(__FUNCTION__, 'afterEach', $item);
            $ids[] = $item->id;
        }
        // afterStore($return)
        $return = $this->_callWith('afterStore', $return, ['item', 'list']);
        $return = $this->_call(__FUNCTION__, 'after', $return);
        return redirect(str_replace(['create', 'factory'], implode(',', $ids), request()->path()));
        request()->whenFilled('num', function ($num) {
            dump(request()->all());
            dd(request()->input('list'));
        })->isNotFilled('num', function ($num) {
            // 2025-01-09 14:10:15 验证表单
            $this->validate_item();
            // 2025-01-09 14:10:24 绑定用户
            request()->merge(['user_id' => Auth::id()]);

            // $content = new \App\Models\Content;
            $item = $this->getModel('class')::make(request()->all());
            $item->save();
            if (empty($item->slug)) {
                // 2025-01-09 14:11:33 若标识为空，则默认为 ID
                $item->slug = $item->id;
                $item->save();
            }
            // 2025-01-09 14:10:41 清除原有关联
            // TODO 清除当前模块下的对应关联(category,tag)
            // \App\Models\Relationship::where("content_id", $content->id)->delete();
            // 2025-01-09 14:10:41 增加指定关联
            // \App\Models\Relationship::insert([
            //     "meta_id" => $this->getAttribute('id'),
            //     "content_id" => $content->id,
            // ]);
            // var_dump($content['slug']);
            // return $this->edit($content->id);
            // return $this->edit($content->id);
            // 2025-01-09 14:10:30 重定向
            return redirect(str_replace(['create', 'factory'], $item->id, request()->path()));
        });
    }
    /**
     * Show the form for editing the specified resource.
     * 显示用于编辑指定资源的表单。
     * @param int|string $ids
     * @done 根据 ID 查询对应资源
     * @return Renderable
     */

    public function edit(string $ids)
    {
        $ids = $this->_call(__FUNCTION__, 'before', $ids);

        $return = $this->getReturn();
        $return['ids'] = $ids = explode(',', $ids);
        // dd($ids);
        $list = select_list([
            '$model' => $this->getModel('class'),
            '$withCount' => ['children', 'relationships', 'files'],
            '$with' => ['relationships', 'children', 'meta_module'],
            '$whereIn' => ['id', $ids]
        ]);
        if (!$list->count()) abort(404);

        if (sizeof($list) == 1) {
            $return['item'] = $list[0];
        } else {
            $return["list"] = $list;
        }
        // $item->append('children_type');

        $return = $this->_call(__FUNCTION__, 'after', $return);
        $this->mergeReturn($return);
        return $this->view('ssential.' . $this->getModel('alias') . '-form', $return);
    }
    /**
     * Update the specified resource in storage.
     * 更新存储中的指定资源。
     * @param 
     * @param int $id
     * @done 根据 ID 查询对应资源
     * @return Renderable
     */
    public function update(string $ids)
    {
        $ids = $this->_call(__FUNCTION__, 'before', $ids);
        $return['ids'] = $ids = explode(',', $ids);
        $num = sizeof($ids);
        $list = request()->input('list', [request()->all()]);

        if ($num == 1 && $validated = $this->validate($list[0], 'item')) return $validated;
        if ($num > 1 && $validated = $this->validate($list, 'list')) return $validated;
        $user_id = Auth::id();

        foreach ($list as $item) {
            $item = $this->_call(__FUNCTION__, 'beforeEach', $item) ?? $item;

            $item = $this->getModel('class')::find($item['id'])->fill($item);

            $item = $this->_call(__FUNCTION__, 'afterEach', $item) ?? $item;

            $item->save();
        }
        $return = $this->_call(__FUNCTION__, 'after', $return);
        return $this->edit(implode(',', $ids));
    }

    /**
     * Remove the specified resource from storage.
     * 从存储中移除指定的资源。
     * @param string $ids
     * @done 根据 ID 查询对应资源
     * @return Renderable|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(string $ids)
    {
        // beforeDestory
        $ids = $this->_call(__FUNCTION__, 'before', $ids);
        $return['ids'] = $ids = explode(',', $ids);
        // dump($ids);
        $list = select_list([
            '$model' => $this->getModel('class'),
            '$whereIn' => ['id', $ids]
        ]);
        foreach ($list as $item) {
            // beforeEachDestory
            $item = $this->_call(__FUNCTION__, 'beforeEach', $item);
            $item->timestamps = false;
            $item->delete();
            // afterEachDestory
            $item = $this->_call(__FUNCTION__, 'afterEach', $item);
        }
        // dd($list);
        // afterDestory
        $return = $this->_call(__FUNCTION__, 'after', $return);
        // redircet to table page
        return redirect(('admin/ssential/' . Str::plural($this->getModel('alias'))));
    }
    /**
     * Summary of import
     * @param \Illuminate\Http\
     */
    public function import()
    {
        $this->_call(__FUNCTION__, 'before');

        if (request()->method() == 'GET')
            return;
        // $file = request()->file('file');
        // var_dump($file);
        if (request()->hasFile('file') && request()->file('file')->isValid()) {
            //
            $alias_id = request()->input('id', request()->input('parent', 0));
            // var_dump(request()->file('file'));

            // var_dump([
            //     'path' => request()->file->path(),
            //     'extension' => request()->file->extension(),
            //     'getPath' => request()->file->getPath(),
            //     'getPathInfo' => request()->file->getPathInfo(),
            //     'getClientOriginalName' => request()->file->getClientOriginalName(),
            //     'getClientOriginalExtension' => request()->file->getClientOriginalExtension(),
            //     'getMaxFilesize' => request()->file->getMaxFilesize(),
            //     'getErrorMessage' => request()->file->getErrorMessage(),
            //     'getError' => request()->file->getError(),
            //     'getPathname' => request()->file->getPathname(),
            //     'getClientMimeType' => request()->file->getClientMimeType(),
            // ]);
            $slug = md5_file(request()->file->path());
            // $file = new $fileModel;
            $file = \App\Models\File::insertOrIgnore([
                'slug' => $slug,
                'name' => request()->file->getClientOriginalName(),
                'mime_type' => request()->file->getClientMimeType(),
                'type' => request()->file->getClientOriginalExtension(),
                'status' => 'protect',
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // var_dump($file);

            // $file->save();
            if ($file) {
                $file = select_item([
                    '$model' => \App\Models\File::class,
                    '$where' => [['slug', $slug]]
                ]);
                // var_dump($file);
                \App\Models\Relationship::upsert(
                    [
                        $this->getModel('alias') . '_id' => $alias_id,
                        'file_id' => $file->id,
                    ],
                    [$this->getModel('alias') . '_id', 'file_id'],
                    [$this->getModel('alias') . '_id', 'file_id'],
                );
                // var_dump($file);
                // $path = request()->file->storeAs('metas/' . request()->file->getClientOriginalExtension(), str_replace(['-', ' ', ':'], '_', $file->created_at) . '_' . request()->file->getClientOriginalName());
                $path = request()->file->storeAs(Str::plural($this->getModel('alias')) . '/' . request()->file->getClientOriginalExtension(), $slug . '.' . request()->file->getClientOriginalExtension());

                // var_dump($path);
                // $file->timestamps = false;
                $file->update([
                    'path' => $path,
                ]);
                $file->save();
            } else {
                $file = select_item([
                    '$model' => \App\Models\File::class,
                    '$where' => [['slug', $slug]]
                ]);
                // var_dump($file);
            }

            return redirect('admin/ssential/files/' . $file->id);

            // switch ($file->type) {
            //     case 'application/json':
            //         $fileContent = \Storage::get($path);
            //         // $this->upsertModelData($request, json_decode($fileContent, true));
            //         upsert_list([
            //             '$model' => \App\Models\Meta::class,
            //             '$list' => json_decode($fileContent, true)['metas'],
            //             '$uniqueBy' => ['slug'],
            //             '$update' => ['slug']
            //         ]);
            //         break;
            //     case 'md':
            //         break;
            //     default:
            //         break;
            // }
            // return redirect('admin//ssential/files/' . $file->id);
        } else {
            return back()->withInput();
        }
        $return = $this->_call(__FUNCTION__, 'after', $return);
        // return $this->index();
    }
    public function export()
    {
        // 
        [
            'alias' => $beforeAlias,
            'class' => $beforeClass,
        ] = $this->_call(__FUNCTION__, 'before');
        // 
        request()->validate([
            'ext' => 'required'
        ]);
        // 
        if ($validated = $this->_call(__FUNCTION__, 'valid',)) return $validated;
        // 
        $alias = $validAlias ?? $this->getModel('alias');
        $class = $validClass ?? $this->getModel('class');
        // $class = $this->getModel('class');
        $fillableColumns = (new $class)->getFillable();
        $plural = Str::plural($alias);
        $ext = request()->input('ext');

        $filename = $plural . '.' . date('Ymdhis') . '.' . $ext;
        $path = Storage::path($filename);

        $contentType = 'text/plain';
        $fileType = 'txt';
        [$exportType, $fileType] = explode('.', request()->input('ext'));
        // var_dump($exportType, $fileType);
        $return = [];

        switch ($exportType) {
            case 'template':
                $return[$alias] = $class::factory()->make();
                $return[$alias . "[:attibute=:value]"] = $class::factory()->make();
                $return[$alias . "[:attibute1=:value1&:attibute2=:value2]"] = $class::factory()->make();
                $return[$plural] = $class::factory(3)->make();
                $return[$plural . "[:attibute=:value]"] = $class::factory(3)->make();
                $return[$plural . "[:attibute1=:value1&:attibute2=:value2]"] = $class::factory(3)->make();
                break;
            default:
                break;
        }
        // dd($return);
        // var_dump(123);
        // dd($return->getAttributes());
        // return;
        switch ($fileType) {
            case 'txt':
                $contentType = 'text/plain';
                break;
            case 'json':
                $contentType = 'application/json';
                break;
            case 'csv':
                $contentType = 'text/csv';
                $item = $return[$alias];
                $return = implode(',', array_keys($item->getAttributes())) . PHP_EOL
                    . implode(',', array_values($item->getAttributes()));
                break;
            case 'xlsx':
                $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                return Export::xlsx($filename, $return, $fillableColumns);
                break;
            case 'xls':
                $contentType = 'application/vnd.ms-excel';
                return Export::xls($filename, $return, $fillableColumns);

                break;
            case 'md':
            case 'sql':
                $contentType = 'application/octet-stream';
                break;
            default:
                break;
        }
        $return = $this->_call(__FUNCTION__, 'after', $return);
        // dd($return);
        return Response::make($return, '200', array(
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename=' . $filename
        ));
    }
}
