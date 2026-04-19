<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

/**
 * 通用标识类模型
 * 
 */
class Meta extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Traits\Model\HasFamily;
    use \App\Traits\Model\HasRelations;
    use \App\Traits\Model\HasUniqueColumn;
    use \App\Traits\Model\HasScope;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "_metas";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'mid';

    protected $relationshipKey = "meta_id";

    protected $fillable = [
        'name',
        'slug',
        'ico',
        'description',
        'type',
        'status',
        'parent',
        'count',
        'order',
        'user_id',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeSelectListOf($query, $params, $remember = 1)
    {
        return  \Cache::remember(
            $this->getTable() . '?' . urldecode(\Arr::query($params)),
            config('cache.seconds'),
            function () use ($params) {
                return $this->toQueryBuilder($params)->get();
            }
        );
    }
    public function scopeSelectItemOf($query, $params) {}
    public function scopeSelectTreeOf($query, $params, $remember = 1) {}
    public function scopeSelectAllOfModule() {}

    public function scopeGetRootModules($query)
    {
        $params = [
            '$whereIn' => ['status', \Auth::check() ? ['public'] : ['public', 'private']],
            '$where' => [['type', 'module'], ['parent', 0]],
        ];
        return  $this->selectListOf($params);
    }

    public function scopeGetTypeOf($query, $type, $module) {}

    public function scopeUpsertEloquent($query, $params) {}
}
