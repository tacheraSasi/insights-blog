<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\ReadingTime;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'category_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function html(): Attribute{
        return Attribute::get(fn ()=> str($this->content)->markdown());
    }

    public function readingTime(): Attribute
    {
        return Attribute::get(fn () => ReadingTime::calculate($this->content));
    }

    public function readingTimeHtml(): Attribute  
    {
        return Attribute::get(fn () => ReadingTime::getReadingTimeHtml($this->content));
    }
}
