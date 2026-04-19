<?php

namespace App\Traits;

use Illuminate\Http\Request;

use function App\Support\Helpers\module_path;

trait HasModuleTrait
{
    public $__module = [
        "id" => null,
        "name" => null,
        "alias" => null,
        "meta" => null,
        "root" => null,
        "parent" => null,
        "children" => null,
        "configs" => null,
        "options" => null,
        "entity" => null,
        "todos" => null,
        // "model" => \App\Models\Meta::class,
    ];

    public function setModule($values, $key = null)
    {
        if (!empty($key)) {
            \Arr::set($this->__module, $key, $values);
        } else {
            $this->__module = array_merge($this->__module, $values);
        }
        return $this->__module;
    }
    private function _initModule()
    {
        // name&alias
        $this->setModuleName();
        // id
        // meta
        // root
        $this->setModuleMeta();
        // children
        // configs
        $this->setModuleConfigs();
        // options
        $this->setModuleOptions();
        // 
        $this->setModuleTodos();
    }
    public function mergeModule($values)
    {
        $this->__module = array_merge($this->__module, $values);
    }
    public function getModule($key = null, $default = null)
    {
        if (empty($key))
            return $this->__module;
        return \Arr::get($this->__module, $key, $default);
    }

    public function getModuleConfigs($key = null, $default = null)
    {
        if (empty($key))
            return \Arr::get($this->__module, 'configs');

        return \Arr::get($this->__module, 'configs.' . $key, config($key, $default));
    }
    public function getModuleOptions($key = null, $default = null)
    {
        if (empty($key))
            return \Arr::get($this->__module, 'options');

        return \Arr::get($this->__module, 'options.' . $key, config($key, $default));
    }

    private function setModuleName($value = null, $pattern = null)
    {
        if (!empty($value)) $name = \Str::studly($value);

        if (empty($pattern)) $pattern = '/^Modules\\\\(\w*)\\\\Http/i';

        // $this->middleware('auth');

        if (empty($name)) {
            if (preg_match($pattern, static::class, $matches)) {
                $name = $matches[1];
            } else {
                $name = 'Home';
            }
        }
        \Arr::set($this->__module, 'name', $name);
        \Arr::set($this->__module, 'alias', \Str::lower($name));
        global $app;
        // \Arr::set($this->__module, 'entity', \Module::find($name) ?? new \Nwidart\Modules\Laravel\Module($app, $name, ''));
    }
    private function setModuleMeta($alias = null)
    {
        if (empty($alias)) $alias = \Arr::get($this->__module, 'alias', 'home');
        $meta = select_item([
            '$model' => \App\Models\Meta::class,
            '$where' => [
                ['type', 'module'],
                ['slug', '' . $alias],
            ]
        ]);
        if (empty($meta))
            return;
        \Arr::set($this->__module, 'meta', $meta);
        \Arr::set($this->__module, 'root', $meta);
    }
    private function setModuleConfigs(...$values)
    {
        if (empty($values)) {
            $this->setModule(array_merge(config(\Arr::get($this->__module, 'alias', 'home')) ?? [], $values), 'configs',);
        }
    }
    private function setModuleOptions(...$values)
    {
        if (empty($values)) {
            $builder = \App\Models\Option::where('name', 'like', 'global.%');
            foreach (['option', 'user', 'meta', 'content', 'link', 'file', 'comment', 'field'] as  $key) {
                $builder = $builder->orWhere('name', 'like', $key . '.%');
            }
            if (\Arr::get($this->__module, 'name'))
                $builder = $builder->orWhere('name', 'like', \Arr::get($this->__module, 'alias', 'home') . '.%');
            $this->setModule($builder->toRawSql(), 'sqls.select_option_list',);
            $values = $builder->get()->toArray();
        }

        foreach ($values as $value) {
            if (isset($value['name']))
                $this->setModule($value['value'], 'options.' . $value['name'],);
        }
    }
    private function setModuleTodos()
    {
        $name = $this->getModule('name');
        $path = null;
        // var_dump($name);
        // var_dump(\module_path($name, 'CHANGELOG.md'));
        $modulePath = \module_path($name, 'CHANGELOG.md');
        $basePath = \base_path('CHANGELOG.md');
        $content = '';
        if (file_exists($basePath)) {
            // $path = $basePath;
            $content .= file_get_contents($basePath) . PHP_EOL;
        }
        if (file_exists($modulePath)) {
            // $path = $modulePath;
            $content .= file_get_contents($modulePath) . PHP_EOL;
        }
        if (!$content) return;
        // dump($content);
        // $return = file_get_contents($path);
        // var_dump($return);
        $return = explode("\r\n", $content);
        // dump($return);
        $return = array_filter($return, function ($item) {
            return preg_match("/^[-|*] \[ \] (.+)$/", trim($item),);
        });
        // dump($return);
        $return = array_map(function ($item) {
            return substr($item, 6);
        }, $return);
        // var_dump($return);
        \Arr::set($this->__module, 'todos', $return);
    }
}
