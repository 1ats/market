@extends('layouts.app')


@section('content')

<h1>criar loja</h1>

<form action="{{route('admin.stores.store')}}" method="post" enctype="multipart/form-data" class="col-lg-12">

	@csrf
	@method("POST")

<div class=" form-group">
	<label>loja</label>
	<input type="text" name="name" class="form-control @error('name') is-invalid 	@enderror " value="{{old('name')}}">
	
	@error('name')
	<div class="invalid-feedback">
		{{$message}}
	</div>

	@enderror
</div>

<div class=" form-group">
	<label>descrição</label>
	<input type="text" name="description" class="form-control @error('description') is-invalid 	@enderror" value="{{old('description')}}">
	@error('description')
	<div class="invalid-feedback">
		{{$message}}
	</div>

	@enderror
	
</div>

<div class=" form-group">
	<label>telefone</label>
	<input type="text" name="phone" id="phone"  class="form-control @error('phone') is-invalid 	@enderror" value="{{old('phone')}} ">
	
	@error('phone')
	<div class="invalid-feedback">
		{{$message}}
	</div>

	@enderror
</div>

<div class=" form-group">
	<label>celular/what</label>
	<input type="text" name="mobile_phone"  class="form-control @error('mobile_phone') is-invalid 	@enderror" value="{{old('mobile_phone')}}">
	
	@error('mobile_phone')
	<div class="invalid-feedback">
		{{$message}}
	</div>

	@enderror
</div>


 <div class="form-group">
     <label>Fotos do Produto</label>
    <input type="file" name="logo" class="form-control  @error('logo') is-invalid @enderror">

            @error('logo')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>




<!--
<div class=" form-group">
	<label>usuario</label>
	<select name="user" class="form-control" >
		@foreach($users as $user)
   <option value="{{$user->id}}"> {{$user->name}} </option> @endforeach		
	</select>
</div>
-->
<div class=" form-group">
	
	<button type="submit" class="btn btn-lg btn-success">criar loja </button>
</div>


</form>
@endsection

@section('scripts')
    <script>
        let imPhone = new Inputmask('(99) 9999-9999');
        imPhone.mask(document.getElementById('phone'));
       
    </script>
       
@endsection