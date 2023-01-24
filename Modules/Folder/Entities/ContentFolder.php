<?php

namespace Modules\Folder\Entities;

use Illuminate\Database\Eloquent\Model;

class ContentFolder extends Model
{
    protected $fillable = ['content_id', 'folder_id',];
}
