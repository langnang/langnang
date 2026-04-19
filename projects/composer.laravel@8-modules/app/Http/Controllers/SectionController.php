<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use App\View\Section;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SectionController extends \Illuminate\Routing\Controller
{
    public static function routes()
    {
        \Route::get('section', function () {
            $view = request()->input('view');
            if (empty($view)) abort(403);
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
            $view = 'sections.' . $view;
            $return = [
                '_moduleAlias' => $module,
                '_moduleId' => $module_id,
                '_frameworkAlias' => $framework,
                '_frameworkId' => $framework_id,
                '_view' => $view,
                '_viewId' => $view_id,
            ];
            // dd($return);
            if ($module || $framework) {
                $module_framework_view = "{$module}::{$framework}.{$view}";
                if (View::exists($module_framework_view)) {
                    Arr::set($return, '_view', $module_framework_view);
                    return view($module_framework_view, $return);
                }
                $module_view = "{$module}::{$view}";
                if (View::exists($module_view)) {
                    Arr::set($return, '_view', $module_view);
                    return view($module_view, $return);
                }
                $framework_view = "{$framework}.{$view}";
                if (View::exists($framework_view)) {
                    Arr::set($return, '_view', $framework_view);
                    return view($framework_view, $return);
                }
            }
            if (!View::exists($view)) abort(404);
            // return Blade::renderComponent(new \App\View\Section(request()->all()));
            return view($view, $return);
        });
    }
}
