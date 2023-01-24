<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Folder\Entities\Folder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Content extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'type'];

    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'content_folders', 'content_id', 'folder_id')->withTimestamps();
    }
}
