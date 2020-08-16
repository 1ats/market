<?php

namespace App;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasSlug;
	protected $fillable = ['name', 'description', 'body', 'price', 'slug'];

/**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }
	//metodo relacionamento  1 por muitos -aula 31 
      public function store()
    {
    // 1 produto tem apenas uma store-loja   -aula 31  
    	return $this->belongsTo(Store::class);
    }
 //metodo relacionamento  muitos por muitos -aula 33
    public function categories()
    {
    	 // varios products possuem varias categorias -aula 33  
    	return $this->belongsToMany(Category::class);
    }

    public function photos()
    {
    	return $this->hasMany(ProductPhoto::class);
    }
}
