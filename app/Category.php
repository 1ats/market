<?php

namespace App;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasSlug;
	protected $fillable = ['name', 'description', 'slug'];
	
/**
	 * Get the options for generating the slug.
	 */
	public function getSlugOptions() : SlugOptions
	{
		return SlugOptions::create()
		                  ->generateSlugsFrom('name')
		                  ->saveSlugsTo('slug');
	}

	//metodo relacionamento  muitos por muitos -aula 33
    public function products()
    {
    	 // varios categorias possuem varias produtos -aula 33 
    	return $this->belongsToMany(Product::class);
    }
}
