<?php

namespace App\Traits\Model;


trait HasScope
{
    public function scopeToQueryBuilder($query, $params)
    {
        // dump($query, $params);
        // $params = \Arr::sort($params);
        // dd($params);
        // $cacheKey = $this->getTable() . '?' . urldecode(\Arr::query($params));
        // dump($cacheKey);
        // dump(urldecode($cacheKey));
        $query = queryWithClauses((array)$params, $query);
        $query = queryWhereClauses((array)$params, $query);
        $query = queryOrderClauses((array)$params, $query);
        $query = queryGroupClauses((array)$params, $query);
        // \Debugbar::info($query->toSql());
        // $this->prependLogs($log);
        return $query;
    }
    public function scopeOfSlug($query, $slug) {}
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOfParent($query) {}


    public function scopeInType($query, $types)
    {
        return $query->whereIn('type', $types);
    }
    public function scopeInStatus($query, $statuses)
    {
        return $query->whereIn('status',  $statuses);
    }

    public function scopeSelectPageOf($query, $params)
    {
        return  \Cache::remember(
            $this->getTable() . '?' . urldecode(\Arr::query($params)),
            config('cache.seconds'),
            function () use ($params) {
                return $this->toQueryBuilder($params)->page();
            }
        );
    }
    public function scopeSelectListOf($query, $params)
    {
        return  \Cache::remember(
            $this->getTable() . '?' . urldecode(\Arr::query($params)),
            config('cache.seconds'),
            function () use ($params) {
                return $this->toQueryBuilder($params)->get();
            }
        );
    }
    public function scopeSelectTreeOf($query, $params) {}
}
