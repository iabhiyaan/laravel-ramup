<?php

namespace Modules\Folder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Content\Entities\Content;

class Folder extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'content_folders', 'folder_id', 'content_id')->withTimestamps();
    }

    public function depthHelper($idToFind)
    {
        return $this->_getParentHelper($idToFind);
    }

// Recursive Helper function
    private function _getParentHelper($id, $depth = 0)
    {
        $model = self::find($id);

        if ($model->parent_id != null) {
            $depth++;

            return $this->_getParentHelper($model->parent_id, $depth);
        } else {
            return $depth;
        }
    }
}
