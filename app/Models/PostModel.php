<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class PostModel extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_posts';
    protected $primary_key = 'id';
    use SoftDeletes;
    protected $fillable = ['user_id', 'title', 'slug', 'thumbnail', 'is_published', 'description', 'created_at', 'updated_at'];
    /**
     * @purpose : get post author
     */
    public function author()
    {
        return $this->hasone(User::class, 'id', 'user_id');
    }
    /**
     * @purpose : create unique slug for post
     */
    public static function createUniqueSlug($title)
    {
        try {
            $slug = '';
            if (static::whereSlug($slug = Str::slug($title))->exists()) {
                //count post of title
                $count = static::where('title', $title)->count();

                $slug =  "{$slug}-{$count}";
            }
            return $slug;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
