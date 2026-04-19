<?php

namespace App\Models;

use Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use Symfony\Component\Yaml\Yaml;


class Content extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Traits\Model\HasFamily;
    use \App\Traits\Model\HasRelations;
    use \App\Traits\Model\HasUser;
    use \App\Traits\Model\HasScope;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "_contents";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'cid';
    protected $relationshipKey = "content_id";
    protected $fillable = [
        'title',
        'slug',
        'ico',
        'description',
        'text',
        'type',
        'status',
        'user_id',
        'template',
        'views',
        'parent',
        'count',
        'order',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at',
    ];
    protected $appends = [
        'config'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    static $fields = [];
    /**
     * Summary of latest
     * @param mixed $perPage
     * @param mixed $columns
     * @param mixed $pageName
     * @param mixed $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function latest_updated($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::latest("updated_at")->paginate($perPage, $columns, $pageName, $page);
    }
    public static function hottest($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::orderBy("views", "desc")->paginate($perPage, $columns, $pageName, $page);
    }

    public static function toplist($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }
    public static function recommend($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }
    public static function collection($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }

    public function getConfigAttribute()
    {
        $return = [];
        $text = trim($this->text);
        // dump($text);
        if (\Str::startsWith($text, '----')) {
            // var_dump($text);
            // var_dump(\Str::between($text, '----', '----'));
            // var_dump(Yaml::parse(\Str::between($text, '----', '----')));
            // dd(\Str::before(\Str::after($text, "----\r\n"), "\r\n----"));
            $return = Yaml::parse(\Str::before(\Str::after($text, "----"), "----"));
        }
        return $this->attributes['config'] = $return;
    }
    public function toArray()
    {
        $return = parent::toArray();

        foreach ($return['fields'] ?? [] as $index => $field) {
            $return['fields'][$field['name']] = (new \App\Models\Field($field))->toArray();
            unset($return['fields'][$index]);
        }
        return $return;
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
}
