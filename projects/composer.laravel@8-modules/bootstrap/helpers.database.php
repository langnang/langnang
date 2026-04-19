<?php

use App\Illuminate\PhpSpider\cache;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

// 
function create_table() {}
// 
function insert_item(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
}
// 
function delete_item(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
}
// 
function update_item(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
}
// 
function upsert_item($data, $model = null)
{
    // if (!$model = $model ?? Arr::get($params, '$model')) return;
}
function upsert_list($data, $model = null)
{
    // if (!$model = $model ?? Arr::get($params, '$model')) return;
    dump($model);
    // if (!($request->filled('$uniqueBy') && $request->filled('$update'))) return;
    // var_dump($params);
    // return $model::upsert(
    //     $request->input('$list', []),
    //     $request->input('$uniqueBy'),
    //     $request->input('$update'),
    // );
}
function upsert_tree(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
}
function upsert_relation_list($data, $keyModelMaps = null)
{
    if (!$keyModelMaps = $keyModelMaps ?? config('models.alias')) return;
    $return = [];
    foreach ($data as $key => $values) {
        $return[$key] = [];
        $modelKey = Str::singular($key);
        $model = config('models.alias.' . $modelKey);
        if (!$model) continue;
        $class = new $model;
        // dump($class);
        $uniqueByColumn = $class->getUniqueColumn();
        $fillableColumns = $class->getFillable();
        // dump($model);
        // dump($uniqueByColumn);
        // dump($fillableColumns);
        foreach ($values as $value) {
            $keys = array_keys($value);
            // $value = collect($updateColumns)->union(collect(array_keys($value)));
            $updateColumns = array_intersect($fillableColumns, array_keys($value));
            $fillableValue = array_filter($value, function ($key) use ($updateColumns) {
                return in_array($key, $updateColumns);
            }, ARRAY_FILTER_USE_KEY);
            // dd($value);
            // dump($updateColumns);
            // $item = $model::updateOrInsert([$uniqueByColumn => $value[$uniqueByColumn]], $value);
            $item = $model::upsert([$fillableValue], [$uniqueByColumn], $updateColumns);
            // dump($item);
            if ($item !== 0)
                $return[$key][] = $model::where($uniqueByColumn, $fillableValue[$uniqueByColumn])->first();
            else
                $return[$key][] = $value;
        }
    }
    return $return;
}
// 
function select_item(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
    Arr::set($params, '$model', $model);
    return  toQueryBuilder($params)->first();
    // return $request->input('$cacheRemember', false)
    //     ? cache_remember(function () use ($request, $model) {
    //         return toQueryBuilder($request->merge(['$model' => $model]))->first();
    //     }, $request->input('$rememberStrictly'), 1)
    //     : toQueryBuilder($request->merge(['$model' => $model]))->first();
}
function select_list(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
    Arr::set($params, '$model', $model);
    return  toQueryBuilder($params)->get();
    // return $request->input('$cacheRemember', false)
    //     ? cache_remember(function () use ($request, $model) {
    //         return toQueryBuilder($request->merge(['$model' => $model]))->get();
    //     }, $request->input('$rememberStrictly'), 1)
    //     : toQueryBuilder($request->merge(['$model' => $model]))->get();
}
function select_page(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
    Arr::set($params, '$model', $model);
    return  toQueryBuilder($params)->paginate(Arr::get($params, '$size'));
    // return $request->input('$cacheRemember', false)
    //     ? cache_remember(function () use ($request, $model) {
    //         return toQueryBuilder($request->merge(['$model' => $model]))->paginate($request->input('$size'));
    //     }, $request->input('$rememberStrictly'), 1)
    //     : toQueryBuilder($request->merge(['$model' => $model]))->paginate($request->input('$size'));
}
function select_tree(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
    Arr::set($params, '$model', $model);
    return  toQueryBuilder($params);
    // return $request->input('$cacheRemember', false)
    //     ? cache_remember(function () use ($request, $model) {
    //         return toQueryBuilder($request->merge(['$model' => $model]));
    //     }, $request->input('$rememberStrictly'), 1)
    //     : toQueryBuilder($request->merge(['$model' => $model]));
}
function select_count(array $params, $model = null)
{
    if (!$model = $model ?? Arr::get($params, '$model')) return;
    Arr::set($params, '$model', $model);
    return  toQueryBuilder($params)->count();
    // return $request->input('$cacheRemember', false)
    //     ? cache_remember(function () use ($request, $model) {
    //         return toQueryBuilder($request->merge(['$model' => $model]))->count();
    //     }, $request->input('$rememberStrictly'), 1)
    //     : toQueryBuilder($request->merge(['$model' => $model]))->count();
}

// 
function queryWithClauses(array $params, $query)
{
    foreach (
        [
            'with',
            'without',
            'withCount',
            'withPivot',
            'withTimestamps',
            'morphWith',
            'morphWithCount',
            'withDefault',
            'syncWithoutDetaching', // 获取包括软删除模型在内的模型
            'withTrashed',
            'onlyTrashed', // 对当前查询取消全局作用域
            'withoutGlobalScope', // 暂时「禁用」模型触发的所有事件
            'withoutEvents',
        ] as $key
    ) {
        if (array_key_exists('$' . $key, $params)) {
            $conditions = Arr::get($params, '$' . $key);
            $query = $query->{$key}($conditions);
        }
    }
    // $this->prependLogs($log);
    return $query;

    // return $request->input('$with', []);
}
function queryWhereClauses(array $params, $query)
{
    foreach (
        [
            'where',
            'orWhere',
            'whereBetween',
            'orWhereBetween',
            'whereNotBetween',
            'orWhereNotBetween',
            'orWhereIn',
            'orWhereNotIn',
            'whereNull',
            'whereNotNull',
            'orWhereNull',
            'orWhereNotNull',
            'whereDate',
            'whereMonth',
            'whereDay',
            'whereYear',
            'whereTime',
            'whereColumn',
            'orWhereColumn',
            'whereHasMorph',
        ] as $key
    ) {

        if (array_key_exists('$' . $key, $params)) {
            $conditions = Arr::get($params, '$' . $key);
            $query = $query->{$key}($conditions);
        }
    }
    foreach (
        [
            'whereHas',
            'whereIn',
            'whereNotIn',
        ] as $key
    ) {

        if (array_key_exists('$' . $key, $params)) {
            $conditions = Arr::get($params, '$' . $key);
            $query = $query->{$key}(...$conditions);
        }
    }
    return $query;
}
function queryOrderClauses(array $params, $query)
{

    foreach (
        [
            'orderBy',
            'orderByDesc'
        ] as $key
    ) {
        if (array_key_exists('$' . $key, $params)) {
            $conditions = Arr::get($params, '$' . $key);
            $conditions = is_array($conditions) ? $conditions : [$conditions];
            $query = $query->{$key}(...$conditions);
        }
    }
    return $query;

    // if ($request->filled('$order') && !empty($request->input('$order'))) {
    //     $order = $request->input('$order');
    //     if (is_array($order)) {
    //         foreach ($order as $args) {
    //             if (is_string($args)) {
    //                 $return = $return->orderBy($args, 'desc');
    //             } else {
    //                 $return = $return->orderBy(...$args);
    //             }
    //         }
    //     } else {
    //         $return = $return->orderBy($order);
    //     }
    //     unset($order);
    // }
    // return $return;
}

function queryGroupClauses(array $params, $query)
{
    return $query;
}
function toQueryBuilder(array $params)
{


    $model = Arr::get($params, '$model');
    // dump($model);
    // dump(($model) instanceof \App\Illuminate\Database\Eloquent\Model);
    // dd(class_exists($model));
    if (class_exists($model) && (new $model) instanceof \Illuminate\Database\Eloquent\Model) {
        $query = $model::select();
    } else {
        $query = \DB::table($model)->select();
    }
    // var_dump($modelFunConfig);
    // $query = $this->queueClauses($request, $query);

    $query = queryWithClauses($params, $query);
    $query = queryWhereClauses($params, $query);
    $query = queryOrderClauses($params, $query);
    $query = queryGroupClauses($params, $query);
    // \Debugbar::info($query->toSql());
    // $this->prependLogs($log);
    return $query;
}


function toRawSql($queryLog)
{
    return array_reduce($queryLog, function ($total, $log) {
        return $total  . array_reduce($log['bindings'], function ($sql, $binding) {
            return preg_replace('/\?/', is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1) . PHP_EOL;
        }, $log['query']);
    }, "");
}
