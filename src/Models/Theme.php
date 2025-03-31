<?php

namespace Wave\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    //
    protected $table = 'themes';

    protected $fillable = ['name', 'folder', 'version'];

    public function options()
    {
        return $this->hasMany('\Wave\Models\ThemeOptions', 'theme_id');
    }
}
