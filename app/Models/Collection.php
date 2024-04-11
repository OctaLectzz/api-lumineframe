<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'collection_photo');
    }
    public function collectionphoto()
    {
        return $this->hasMany(CollectionPhoto::class);
    }
}
