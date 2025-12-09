<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
  use HasFactory;

  protected $table = "guides";

  public function children()
  {
    return $this->hasMany(static::class, 'parent');
  }

  public function sites()
  {
    return $this->hasMany(static::class, 'parent');
  }
}
