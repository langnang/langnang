<?php

namespace App\Models;

class Relationship extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "_relationships";
    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;
    protected $fillable = [];

    protected $casts = [];

    public function toArray()
    {
        $return = parent::toArray();

        $return = array_filter($return, function ($value) {
            return $value !== null && $value !== false && $value !== '';
        });

        return $return;
    }
}
