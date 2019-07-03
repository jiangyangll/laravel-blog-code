<?php

namespace App\Models;

use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
	protected $fillable = [
    	'title', 'subtitle', 'content_raw', 'page_image', 'meta_description','layout', 'is_draft', 'published_at',
	];

    protected $dates = ['published_at'];

    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'post_tag_pivot');
    }

    public function setTitleAttribute($value)
    {
    	$this->attributes['title'] = $value;

    	/*if (!$this->exists()) {
    		$this->attributes['slug'] = str_slug($value);
    	}*/

    	if (!$this->exists) {
            $value = uniqid(str_random(8));
            $this->setUniqueSlug($value, 0);
        }
    }

	public function setUniqueSlug($title, $extra)
	{
		$slug = str_slug($title . '-' . $extra);

		if (static::where('slug', $slug)->exists()) {
            $this->setUniqueSlug($title, $extra + 1);
            return;
        }

		$this->attributes['slug'] = $slug;
	}

	public function setContentRawAttribute($value)
	{
		$markdown = new Markdowner();

		$this->attributes['content_raw'] = $value;
		$this->attributes['content_html'] = $markdown->toHTML($value);
	}

	public function syncTags(array $tags)
	{
		Tag::addNeededTags($tags);

		if (count($tags)) {
			$this->tags()->sync(
				Tag::whereIn('tag', $tags)->get()->pluck('id')->all()
			);
			return;
		}

		$this->tags()->detach();
	}

	public function getPublishDateAttribute($value)
	{
		return $this->published_at->format('Y-m-d');
	}

	public function getPublishTimeAttribute($value)
	{
		return $this->published_at->format('g:i A');
	}

	public function getContentAttribute($value)
	{
		return $this->content_raw;
	}
}
