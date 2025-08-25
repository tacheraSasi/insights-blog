<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\ReadingTime;
use App\Helpers\TableOfContents;

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

    public function topLevelComments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('allReplies', 'user');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(InsightView::class);
    }

    public function uniqueViews(): int
    {
        return $this->views()->distinct('ip_address')->count();
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

    public function tableOfContents(): Attribute
    {
        return Attribute::get(fn () => TableOfContents::generate($this->content));
    }

    public function tableOfContentsHtml(): Attribute
    {
        return Attribute::get(fn () => TableOfContents::generateHtml($this->table_of_contents));
    }

    public function shouldShowToc(): Attribute
    {
        return Attribute::get(fn () => TableOfContents::shouldShowToc($this->content));
    }

    public function contentWithTocIds(): Attribute
    {
        return Attribute::get(fn () => TableOfContents::addHeaderIds($this->content));
    }

    public function isLikedBy($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }
        
        if (!$user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isBookmarkedBy($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }
        
        if (!$user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
}
