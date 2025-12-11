<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'content',
        'image_path',
    ];
}
