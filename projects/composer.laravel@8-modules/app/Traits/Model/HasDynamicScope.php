<?php

namespace \App\Traits\Model;

trait HasDynamicScope
{
    function scopeOfType($query, $type){
        return $query->where('type', $type);
    }
    function scopeOfStatus($query, $status){
        return $query->where('status', $status);
    }
}