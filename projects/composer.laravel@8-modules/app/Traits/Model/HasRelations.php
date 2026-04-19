<?php

namespace App\Traits\Model;

trait HasRelations
{
    // public function metas()
    // {
    //     return $this
    //         ->hasMany(\App\Models\Relationship::class, 'meta_id', 'meta_id')
    //         ->leftJoin("metas", "relationships.meta_id", '=', "metas.id");
    // }

    // public function links()
    // {
    //     return $this
    //         ->hasMany(\App\Models\Relationship::class, 'link_id', 'link_id')
    //         ->leftJoin("links", "relationships.link_id", '=', "links.id");
    // }

    // public function relationships()
    // {
    //     return $this->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey);
    // }
    public function belongsToMeta()
    {
        return $this->belongsToMany(\App\Models\Meta::class, \App\Models\Relationship::class, 'content_id', 'meta_id');
    }
    public function fields()
    {
        return $this->hasMany(\App\Models\Field::class, $this->primaryKey, $this->primaryKey);
    }
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, $this->primaryKey, $this->primaryKey);
    }
    public function metas()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->rightJoin('_metas', function ($join) {
                $join->on("_relationships.meta_id", '=', "_metas.id")
                    ->whereNotNull($this->relationshipKey)
                ;
            })
        ;
    }
    public function meta_module()
    {
        return $this
            ->hasOne(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->rightJoin('_metas', function ($join) {
                $join->on("_relationships.meta_id", '=', "_metas.id")
                    ->whereNotNull($this->relationshipKey)
                    ->where([['type', 'module']])
                ;
            })
        ;
    }
    public function meta_modules() {}
    public function meta_categories() {}
    public function meta_tags() {}
    public function relation_modules()
    {
        return $this->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->rightJoin('_metas', function ($join) {
                $join->on("_relationships.meta_id", '=', "_metas.id")
                    ->whereNotNull($this->relationshipKey)
                    ->where('type', 'module');
            });
    }
    // public function relation_categories() {}
    // public function relation_tags() {}

    public function contents()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("_contents", "_relationships.content_id", '=', "_contents.id")->select('_contents.*');
    }
    public function content_posts() {}
    public function content_pages() {}
    public function content_templates() {}

    public function links()
    {
        // return $this->belongsToMany(\App\Models\Link::class, 'relationships', $this->relationshipKey, $this->primaryKey);
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("_links", "_relationships.link_id", '=', "_links.id")->select('_links.*');
    }
    public function link_sites() {}

    public function files()
    {
        // return $this->belongsToMany(\App\Models\Link::class, 'relationships', $this->relationshipKey, $this->primaryKey);
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("_files", "_relationships.file_id", '=', "_files.id")->select('_files.*');
    }
    public function relation_files() {}
    public function relationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey);
    }

    public function logs() {}
}
