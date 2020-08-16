<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Notifications\StoreReceiveNewOrder;

class Store extends Model
{
	use HasSlug;
	protected $fillable = ['name', 'description', 'phone', 'mobile_phone', 'slug', 'logo'];
     
  /**
	 * Get the options for generating the slug.
	 */
	public function getSlugOptions() : SlugOptions
	{
		return SlugOptions::create()
		                  ->generateSlugsFrom('name')
		                  ->saveSlugsTo('slug');
	}


     //metodo relacionamento  1 por 1 aula 30  
    public function user()
	{
		 // 1 story-loja so tem um user -aula 30  

		return $this->belongsTo(User::class);
	}
    //metodo relacionamento  1 por muitos -aula 31  
	public function products()
	{
		// 1 story-loja  tem varios  produtos -aula 31  
		return $this->hasMany(Product::class);
	}

	public function orders()
	{
		
		return $this->belongsToMany(UserOrder::class, 'order_store', null, 'order_id');
		//return $this->belongsToMany(UserOrder::class, 'order_store' , 'store_id', 'order_id');
	}

	public function notifyStoreOwners(array $storesId = [])
	{
		$stores = $this->whereIn('id', $storesId)->get();

		$stores->map(function($store){
			return $store->user;
		})->each->notify(new StoreReceiveNewOrder());
	}

}
