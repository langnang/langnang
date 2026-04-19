<?php

namespace App\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Section extends \Illuminate\View\Component
{
    public $name;
    public $id;
    public $class;
    public $itemClass;
    public $data;
    public $props;
    public $module;
    public $return;
    public $_moduleAlias = '';
    public $_moduleId;
    public $_frameworkAlias;
    public $_frameworkId;
    public $_view;
    public $_viewId;
    /**
     * 创建一个组件实例。
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct(array $params)
    {
        $view = Arr::get($params, 'view');
        if (empty($view)) return;
        // ::
        $module = strstr($view, "::", true);
        $module_id = null;
        // dump($module);
        if (substr($view, 0, strlen($module) + 2) === $module . "::") {
            $view = substr($view, strlen($module) + 2);
            $module_id = Str::between($module, '(', ')');
            $module = Str::before($module, '(');
        }
        // dump($view);
        // :
        $framework = strstr($view, ":", true);
        $framework_id = null;
        // dump($framework);
        if (substr($view, 0, strlen($framework) + 1) === $framework . ":") {
            $view = substr($view, strlen($framework) + 1);
            $framework_id = Str::between($framework, '(', ')');
            $framework = Str::before($framework, '(');
        }
        $view_id = Str::between($view, '(', ')');
        $view = Str::before($view, '(');
        // dump($view);
        $this->name = $view;
        $this->return = [
            '_moduleAlias' => $module,
            '_moduleId' => $module_id,
            '_frameworkAlias' => $framework,
            '_frameworkId' => $framework_id,
            '_view' => $view,
            '_viewId' => $view_id,
        ];
        dump($this);
    }

    /**
     * 获取组件的视图 / 内容
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        if (empty($this->name)) return;
        $view = 'sections.' . $this->name;
        $return = $this->return;
        $module = Arr::get($this->return, '_moduleAlias');
        $framework = Arr::get($this->return, '_frameworkAlias');
        if ($module || $framework) {
            $module_framework_view = "{$module}::{$framework}.{$view}";
            if (View::exists($module_framework_view)) {
                Arr::set($return, '_view', $module_framework_view);
                dd($return);
                return view($module_framework_view, $return);
            }
            $module_view = "{$module}::{$view}";
            if (View::exists($module_view)) {
                Arr::set($return, '_view', $module_view);
                dd($return);
                return view($module_view, $return);
            }
            $framework_view = "{$framework}.{$view}";
            if (View::exists($framework_view)) {
                Arr::set($return, '_view', $framework_view);
                // dd($return);
                return view($framework_view, $return);
            }
        }
        if (!View::exists($view)) return;
        return view($view, $return);
    }
}
