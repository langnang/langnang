<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Universal management controller
 * 通用管理控制器
 * @method __construct()
 * @method __beforeConstruct()
 * @method __afterConstruct()
 * @method index()
 * @method beforeIndex()
 * @method afterIndex($return)
 * @method create()
 * @method beforeCreate()
 * @method afterCreate($return)
 * @method factory()
 * @method beforeFactory()
 * @method beforeEachFactory($item)
 * @method afterEachFactory($item)
 * @method afterFactory($return)
 * @method store()
 * @method beforeStore()
 * @method beforeEachStore($item)
 * @method afterEachStore($item)
 * @method afterStore($return)
 * @method edit(string $ids)
 * @method beforeEdit(array $ids)
 * @method beforeEachEdit($item)
 * @method afterEachEdit($item)
 * @method afterEdit($return)
 * @method update(string $ids)
 * @method beforeUpdate(array $ids)
 * @method beforeEachUpdate($item)
 * @method afterEachUpdate($item)
 * @method afterUpdate($return)
 * @method destory(string $ids)
 * @method beforeDestory(array $ids)
 * @method beforeEachDestory($item)
 * @method afterEachDestory($item)
 * @method afterDestory($return)
 * @method import()
 * @method beforeImport()
 * @method beforeEachImport($item)
 * @method afterEachImport($item)
 * @method afterImport($return)
 * @method export()
 * @method beforeExport()
 * @method beforeEachExport($item)
 * @method afterEachExport($item)
 * @method afterExport($return)
 * @method move()
 * @method copy()
 * @method validate()
 */
class AdminController extends \App\Illuminate\Routing\Controller
{
    use \App\Traits\HasBladeViewTrait;
    use \App\Traits\HasModelTrait;
    use \App\Traits\HasModuleTrait;
    use \App\Traits\HasOptionsTrait;
    use \App\Traits\HasReturnTrait;


    protected $__validations = [];

    public function __construct()
    {
        $this->_call(__FUNCTION__, 'before',);
        // $this->setName($moduleName, $pattern);
        $this->_initModule();

        $this->_initBladeView();

        $this->_initOptions();

        $this->mergeModule(cache_remember(function () {
            $return = [
                'associated_modules' => select_list([
                    '$model' => \App\Models\Meta::class,
                    '$where' => [
                        ['type', 'module'],
                        ['parent', $this->getModule('root.id')]
                    ],
                ]),
                'associated_tags' => select_list([
                    '$model' => \App\Models\Meta::class,
                    '$where' => [
                        ['type', 'tag'],
                        ['parent', $this->getModule('root.id')]
                    ],
                ]),
                'associated_categories' => select_list([
                    '$model' => \App\Models\Meta::class,
                    '$where' => [
                        ['type', 'category'],
                        ['parent', $this->getModule('root.id')]
                    ],
                    '$orderBy' => ['order', 'asc'],
                ]),
                'associated_links' => select_list([
                    '$model' => \App\Models\Link::class,
                ]),
                'associated_latest_comments' => [],
                'associated_hottest_contents' => [],
            ];
            return $return;
        }));
        $this->mergeBladeView([
            'meta_modules' => \App\Models\Meta::getRootModules(),
            'metas[type=module&parent=0]' => select_list([
                '$model' => \App\Models\Meta::class,
                '$where' => [
                    ['type', 'module'],
                    ['parent', 0]
                ],
            ]),
            // 'meta_modules' => select_list([
            //     '$model' => \App\Models\Meta::class,
            //     '$where' => [
            //         ['type', 'module'],
            //         ['parent', 0]
            //     ],
            // ]),
            // 'attributes' => $this->getModule(),
            '_module' => $this->getModule(),
            '_options' => $this->getOptions(),
            'layout' => $this->getModuleConfigs('view.layout'),
            'framework' => $this->getModuleConfigs('view.framework'),
            'alias' => $this->getModule('alias'),
        ]);
        // var_dump($this);
        $this->_call(__FUNCTION__, 'after',);
    }
    static function routes()
    {
        if (method_exists(static::class, 'index')) Route::get('/', [static::class, 'index']);
        // beforeImport
        if (method_exists(static::class, 'import')) Route::post('/', [static::class, 'import']);
        // afterImport
        if (method_exists(static::class, 'create')) Route::get('/create', [static::class, 'create']);
        if (method_exists(static::class, 'store')) Route::post('/create', [static::class,  'store']);

        if (method_exists(static::class, 'factory')) Route::get('/factory', [static::class,  'factory']);
        if (method_exists(static::class, 'store')) Route::post('/factory', [static::class,  'store']);

        if (method_exists(static::class, 'store')) Route::post('/store', [static::class,  'store']);


        if (method_exists(static::class, 'edit')) Route::get('/{ids}', [static::class, 'edit']);
        if (method_exists(static::class, 'update')) Route::post('/{ids}', [static::class,  'update']);

        if (method_exists(static::class, 'edit')) Route::get('/delete/{ids}', [static::class,  'edit']);
        if (method_exists(static::class, 'destroy')) Route::post('/delete/{ids}', [static::class,  'destroy']);

        if (method_exists(static::class, 'import')) Route::post('/import/{ids}', [static::class,  'import']);

        if (method_exists(static::class, 'export')) Route::get('/export', [static::class,  'export']);

        // if (method_exists(static::class, 'upsert')) Route::get('/upsert', [static::class,  'upsert']);

        // Route::get('/export123', function () {
        //     dd(123);
        // });

        // if (method_exists(static::class, 'list'))   Route::get('/list', [static::class, 'list']);
    }

    public function _call($function, $life = '', ...$args)
    {
        $_function = Str::camel(implode('_', [$life, $function,]));
        // dump($_function);
        if (preg_match("/^\_+/", $function, $match)) {
            $match[] = $_function;
            $_function = implode('', $match);
        }
        // dump($_function);
        $return = null;
        if (in_array($life, ['before']) && method_exists($this, "_$life")) $args = $this->{"_$life"}(...$args);

        if (method_exists($this, $_function)) $return = $this->{$_function}(...$args);

        if (in_array($life, ['after']) && method_exists($this, "_$life")) $return = $this->{"_$life"}($return, ...$args);

        if (!empty($return)) return $return;

        if (sizeof($args) == 1) return $args[0];

        if (sizeof($args) > 1) return $args;

        return;

        // dump([$method, $life, $args]);
        // dump(preg_match("/^\_+/", $method, $match));
        // dump($match);
        // dump(Str::camel($method));
        // dd();
    }

    public function _callWith($function, $data = [], ...$keys)
    {
        // dump([$function, $life = '', $return, $keys]);
        foreach (Arr::collapse($keys) as $key) {
            $_function = Str::camel(implode('_', [$function, 'with', $key]));
            // dump($_function);
            if (method_exists($this, $_function)) $data[$key] = $this->{$_function}(Arr::get($data, $key));
            // with($return,$key)
            // dump($key);
        }
        return $data;
    }

    public function validate($data, $key)
    {
        $validator = $this->validateModel($data, $key);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return;
    }
}
