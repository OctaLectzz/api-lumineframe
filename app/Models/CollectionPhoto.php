<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionPhoto extends Model
{
    use HasFactory;

    protected $table = 'collection_photo';

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
