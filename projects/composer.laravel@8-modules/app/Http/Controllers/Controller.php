<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class Controller extends \App\Illuminate\Routing\Controller
{
    use \App\Traits\HasBladeViewTrait;
    use \App\Traits\HasModuleTrait;
    use \App\Traits\HasModulesTrait;

    public function __construct($moduleName = null, $pattern = null)
    {
        // $this->setName($moduleName, $pattern);
        $this->_initModule();
        $this->_initModules();
        $this->_initBladeView();

        $this->mergeModule($return = [
            'associated_modules' => \App\Models\Meta::selectListOf([
                '$with' => ['children' => function ($query) {
                    $query->where('type', 'module');
                }],
                '$where' => [
                    ['type', 'module'],
                    ['parent', $this->getModule('root.id')]
                ],
            ]),
            // select_list([
            //     '$model' => \App\Models\Meta::class,
            //     '$with' => ['children' => function ($query) {
            //         $query->where('type', 'module');
            //     }],
            //     '$where' => [
            //         ['type', 'module'],
            //         ['parent', $this->getModule('root.id')]
            //     ],
            // ]),
            'associated_tags' => \App\Models\Meta::selectListOf([
                '$where' => [
                    ['type', 'tag'],
                    ['parent', $this->getModule('root.id')]
                ],
            ]),
            // select_list([
            //     '$model' => \App\Models\Meta::class,
            //     '$where' => [
            //         ['type', 'tag'],
            //         ['parent', $this->getModule('root.id')]
            //     ],
            // ]),
            'associated_categories' =>  \App\Models\Meta::selectListOf([
                '$with' => ['children'],
                '$where' => [
                    ['type', 'category'],
                    ['parent', $this->getModule('root.id')]
                ],
                '$orderBy' => ['order', 'asc'],
            ]),
            // select_list([
            //     '$model' => \App\Models\Meta::class,
            //     '$with' => ['children'],
            //     '$where' => [
            //         ['type', 'category'],
            //         ['parent', $this->getModule('root.id')]
            //     ],
            //     '$orderBy' => ['order', 'asc'],
            // ]),
            'associated_links' =>  \App\Models\Meta::selectListOf([
                '$with' => ['belongsToMeta'],
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
            // select_list([
            //     '$model' => \App\Models\Link::class,
            //     '$with' => ['belongsToMeta'],
            //     '$whereHas' => ['belongsToMeta', function ($query) {
            //         $query->where('meta_id', $this->getModule('root.id'));
            //     }],
            // ]),
            'associated_latest_comments' => [],
            'associated_hottest_contents' => [],
        ]);
        $this->mergeBladeView([
            // 'attributes' => $this->getModule(),
            '_env' => $_ENV,
            '_module' => $this->getModule(),
            '_modules' => $this->getModules(),
            'alias' => $this->getModule('alias'),
            'framework' => $this->getModuleConfigs('view.framework'),


        ]);
        // var_dump($this);
    }


    static function routes()
    {
        \Route::get('/', [static::class, 'view_index']);
        \Route::get('/meta/{id}',  [static::class, 'view_meta_item']);
        \Route::get('/content/{id}', [static::class, 'view_content_item']);
    }
    public function section_meta_tree()
    {
        return $this->view('sections.meta_tree', []);
    }
    public function section_content_page()
    {
        $_where = [
            ['parent', request()->input('parent', 0)],
            ['type', 'post'],
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
        // return Blade::render('Blade template string', $data);
        return $this->view('sections.content_page', [
            'content_posts' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => $_where,
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
            'content_pages' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => [['type', 'page'],],
                '$whereIn' => ['status', ['public', 'publish']],
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
            'posts' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => $_where,
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function view_index()
    {
        Debugbar::info(__METHOD__);
        $_where = [
            ['parent', request()->input('parent', 0)],
            ['type', 'post'],
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
        return $this->view('index', [
            'content_posts' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => $_where,
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
            'content_pages' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => [['type', 'page'],],
                '$whereIn' => ['status', ['public', 'publish']],
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
            'posts' => select_page([
                '$model' => \App\Models\Content::class,
                '$with' => ['belongsToMeta'],
                '$where' => $_where,
                '$whereHas' => ['belongsToMeta', function ($query) {
                    $query->where('meta_id', $this->getModule('root.id'));
                }],
            ]),
        ]);
    }
    public function view_meta_item($id)
    {
        return $this->view('index', [
            'meta' => \App\Models\Meta::find($id),
            // select_item([
            //     '$model' => \App\Models\Meta::class,
            //     '$where' => [['id', $id]]
            // ]),
            'posts' => \App\Models\Content::selectPageOf([
                '$where' => [['type', 'post']]
            ]),
            // select_page([
            //     '$model' => \App\Models\Content::class,
            //     '$where' => [['type', 'post']]
            // ])
        ]);
    }
    public function section_content_item($id)
    {
        return $this->view('sections.content_item', [
            'content' => select_item([
                '$model' => \App\Models\Content::class,
                '$where' => [['id', $id]]
            ]),
            // 'posts' => $this->select_content_page(['$where' => [['type', 'post']]]))
        ]);
    }
    public function view_content_item($id)
    {
        return $this->view('content', [
            'id' => $id,
            'content' => select_item([
                '$model' => \App\Models\Content::class,
                '$where' => [['id', $id]]
            ]),
            // 'posts' => $this->select_content_page(['$where' => [['type', 'post']]]))
        ]);
    }
}


trait TempController
{
    /**
     * 与控制器关联的模型列表
     * @var array
     */
    protected $models = [
        'meta' => \App\Models\Meta::class,
        'content' => \App\Models\Content::class,
        'link' => \App\Models\Link::class,
        'file' => \App\Models\File::class,
        'relationship' => \App\Models\Relationship::class,
        'field' => \App\Models\Field::class,
        'comment' => \App\Models\Comment::class,
        'user' => \App\Models\User::class,
        'option' => \App\Models\Option::class,
        'log' => \App\Models\Log::class,
    ];
    /**
     * Summary of view
     * @param mixed $view
     * @param mixed $data
     * @param mixed $mergeData
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Contracts\View\View
     */
    protected function _view($view = null, $data = [], $mergeData = [])
    {
        \DB::enableQueryLog();

        // $this->setMetaAttributes();

        // $this->setContentAttributes();

        // $this->setLinkAttributes();


        // // metas[type=category]
        // $this->setAttribute('categories', $this->select_meta_categories(request()));
        // // metas[type=tag]
        // $this->setAttribute('tags', $this->select_meta_tags(request()));
        // // metas[type=module]
        // $this->setAttribute('modules', $this->select_meta_modules(request()));
        // // contents[type=template]
        // $this->setAttribute('templates', $this->select_content_templates(request()));
        // // contents[type=page]
        // $this->setAttribute('pages', $this->select_content_pages(request()));
        // // links[type=site]
        // // 根据模块对应的 MetaID 
        // $this->setAttribute('links', $this->select_link_sites(request()));

        // $this->setAttribute('latest_posts', $this->select_content_latest_posts(request()));

        // $this->setAttribute('latest_comments', []);
        // var_dump(__METHOD__);
        // $metaRelations = $this->module->relationships()->get();
        // var_dump($metaRelations->toArray());

        // $links = $this->getModel('link')::get();

        // $sql = \Blade::render('SELECT meta_id, cheatsheet_id  FROM `relationships`', $data);
        // $links = \App\Models\Link::with(['relationships'])->limit(1)->toSql();
        // var_dump($links->toArray());
        $return = array_merge($data, [
            // contents[type=post]
            'posts' => \Arr::get($data, 'posts', []),
            'categories' => $this->select_meta_list(new Request([
                '$where' => [
                    "type" => "category"
                ],
                '$with' => ['children']
            ]))

        ]);


        if (empty($return['posts'])) {
            $query = $this->getModel('content')::with(['belongsToMeta', 'user'])->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getModule('id'));
            });
            if (request()->filled('title')) {
                $query = $query->where('title', 'like', '%' . request()->input('title') . '%');
            }
            $query = $query->where('type', 'post');
            $query = $query->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish']);
            $query = $query->whereNull('deleted_at');
            $query = $query->orderByDesc('updated_at');
            $query = $query->paginate();
            $return['posts'] = $query;
            unset($query);
        }

        return parent::view($view, $return, $mergeData);
    }
    public function content($id) {}
    public function welcome()
    {
        return $this->view('welcome');
    }
    protected function setMetaAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.meta_attributes', 60 * 60 * 24, function () {
            return [
                'categories' => $this->select_meta_categories(request()),
                'tags' => $this->select_meta_tags(request()),
                'modules' => $this->select_meta_modules(request()),
            ];
        });
        foreach ($return as $key => $value) {
            $this->setModule($value, $key);
        }
        // $this->setAttributes($return);
    }
    protected function setContentAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.content_attributes', 60 * 60, function () {
            return [
                'templates' => $this->select_content_templates(request()),
                'pages' => $this->select_content_pages(request()),
                'latest_posts' => $this->select_content_latest_posts(request()),
                'latest_comments' => [],
            ];
        });
        foreach ($return as $key => $value) {
            $this->setModule($value, $key);
        }
        // $this->setAttributes($return);
    }
    protected function setLinkAttributes()
    {
        $return = \Cache::remember($this->alias . '_module.link_attributes', 60 * 60 * 24, function () {
            return [
                'links' => $this->select_link_sites(request()),
            ];
        });
        foreach ($return as $key => $value) {
            $this->setModule($value, $key);
        }
        // $this->setAttributes($return);
    }
    /**
     * Summary of getMetaModules
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_modules(Request $request)
    {

        $query = $this->getModel('meta')::with([
            'children' => function ($query) {
                $query->where('type', 'module');
            },
            'relationships'
        ])->where('type', 'module')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->where('parent', 0)
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        Debugbar::info('select_meta_modules');
        // $this->setAttributeSql('select_meta_modules');
        return $query;
    }
    /**
     * Summary of getMetaCategories
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_categories(Request $request)
    {
        $query = $this->getModel('meta')::with(['children'])
            ->where('parent', $this->getModule('id'))
            ->where('type', 'category')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        Debugbar::info('select_meta_categories');
        // $this->setAttributeSql('select_meta_categories');
        return $query;
    }
    /**
     * Summary of getMetaTags
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function select_meta_tags(Request $request)
    {
        $query = $this->getModel('meta')::with([])
            ->where('type', 'tag')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->where('parent', $this->getModule('id'))
            ->whereNull('deleted_at')
            ->where('name', '!=', '')
            ->get();
        Debugbar::info('select_meta_tags');
        // $this->setAttributeSql('select_meta_tags');
        return $query;
    }


    protected function select_content_latest_posts(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getModule('id'));
            })
            ->where('type', 'post')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        Debugbar::info('select_content_latest_posts');
        // $this->setAttributeSql('select_content_latest_posts');
        return $query;
    }
    protected function select_content_templates(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getModule('id'));
            })
            ->where('type', 'template')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        Debugbar::info('select_content_templates');
        // $this->setAttributeSql('select_content_templates');
        return $query;
    }
    protected function select_content_pages(Request $request)
    {
        $query = $this->getModel('content')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getModule('id'));
            })
            ->where('type', 'page')
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        Debugbar::info('select_content_pages');
        // $this->setAttributeSql('select_content_pages');
        return $query;
    }

    /**
     * 查询 模块Meta 关联的Link[type=site]
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function select_link_sites(Request $request)
    {
        $query = $this->getModel('link')::with(['belongsToMeta', 'relationships'])
            ->whereHas('belongsToMeta', function ($query) {
                $query->where('meta_id', $this->getModule('id'));
            })
            ->where('type', 'site')
            ->whereIn('type', ['site'])
            ->whereIn('status', \Auth::check() ? ['public', 'publish', 'protected', 'private'] : ['public', 'publish'])
            ->whereNull('deleted_at')
            ->where('title', '!=', '')
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get();
        Debugbar::info('select_link_sites');
        // $this->setAttributeSql('select_link_sites');
        return $query;
    }
}
