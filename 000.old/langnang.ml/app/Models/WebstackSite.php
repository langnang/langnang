<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebstackSite extends Model
{
  public function category()
  {
    return $this->belongsTo(WebstackCategory::class, 'category_id');
  }
}
