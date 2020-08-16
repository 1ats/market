<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Traits\UploadTrait;


class StoreController extends Controller
{

use UploadTrait;
  

  public function __construct(){

     // user.has.store é o  middleware para comtrol das classe create e store
    // $this->middleware('user.has.store')->only(['create', 'store']);
  }

  public function index(){

   // $stores = \App\Store::all();
  	//$stores = \App\Store::paginate(10);
    $store = auth()->user()->store;

	//return  $stores;
	return  view('admin.stores.index', compact('store'));
}

public function create(){

	
   $users = \App\User::all(['id', 'name']);
	return view ('admin.stores.create', compact('users'));
   }
     
     // este metodod receberá os dados do formulario  
   public function store(StoreRequest $request){


	$data =  $request->all();
  $user = auth()->user();  // pega o usuario autemticado
 //	$user = \App\User::find($data['user']);

  if($request->hasFile('logo')) {
      $data['logo'] = $this->imageUpload($request->file('logo'));
    }

	$store = $user->store()->create($data);

	 flash('Loja criada com sucesso')->success();
      return redirect()->route('admin.stores.index');   

   }

   public function edit($store)
    {
    	$store = \App\Store::find($store);

    	return view('admin.stores.edit', compact('store'));
    }



    public function update(StoreRequest $request, $store)
    {
    	$data = $request->all();
     
      $store = \App\Store::find($store);

      if($request->hasFile('logo')) {
      if(\Storage::disk('public')->exists($store->logo)) {
        \Storage::disk('public')->delete($store->logo);
      }

        $data['logo'] = $this->imageUpload($request->file('logo'));
      }

	    $store->update($data);

      flash('Loja atualizada com sucesso')->success();
	    return redirect()->route('admin.stores.index');   
    }


    public function destroy($store)
    {
		$store = \App\Store::find($store);
		$store->delete();

	    //flash('Loja Removida com Sucesso')->success();
	     // return redirect()->route('admin.stores.index');
		  flash('Loja removida com sucesso')->success();
      return redirect()->route('admin.stores.index');   
    }

}