<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Payment\PagSeguro\Notification;
use App\Store;
use App\UserOrder;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Http\Notifications\StoreReceiveNewOrder;

class CheckoutController extends Controller
{
	public function index()
    {
      // session()->forget('pagseguro_session_code');
    	// usuario não está autenticado
    	if(!auth()->check()) {
    		//manda ele para o login 
			return redirect()->route('login') ;
	    }

       if (!session()->has('cart')) return redirect()->route('home');

     $this->makePagSeguroSession();
      var_dump(session()->get('pagseguro_session_code'));


      $cartItems = array_map( function($line){
         
         return $line['amount']*$line['price'];

      }, session()->get('cart'));

      $cartItems = array_sum($cartItems);

      return view('checkout', compact('cartItems'));
	    
    }

     public function proccess(Request $request)
     {

      try {

      $dataPost = $request->all();
      $user = auth()->user();
      $cartItems = session()->get('cart');
      $stores = array_unique(array_column($cartItems, 'store_id'));
      $reference = 'XPTO';
     // $reference = Uuid::uuid4();

      //$stores = array_unique(array_column($cartItems, 'store_id'));
      //$reference = Uuid::uuid4();

      $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);
     $result = $creditCardPayment->doPayment();




     $userOrder = [
        
          'reference' => $reference,
          'pagseguro_code' => $result->getCode(),
          'pagseguro_status' => $result->getStatus(),
          'items' => serialize($cartItems),
         
           // 'store_id' => 1  
        ];

       $userOrder = $user->orders()->create($userOrder);

       $userOrder->stores()->sync($stores);

        //Notificar loja de novo pedido
        $store = (new Store())->notifyStoreOwners($stores);

             session()->forget('cart');
             session()->forget('pagseguro_session_code');



         return response()->json([
          'data' => [
            'status' => true,
            'message' => 'Pedido criado com sucesso!',
            'order' =>   $reference
          ]
        ]);
        
      }  catch (\Exception $e) {
        $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido!';

        return response()->json([
          'data' => [
            'status' => false,
            'message' => $message
          ]
        ], 401);
      }
    }

   
      public function thanks()
    {
      return view('thanks');
    }


    public function notification()
    {
      // try{
          $notification = new Notification();
       //  $notification = $notification->getTransaction();
         var_dump($notification->getTransaction());


      /*
      $reference = base64_decode($notification->getReference());

        $userOrder = UserOrder::whereReference($reference);
        $userOrder->update([
          'pagseguro_status' => $notification->getStatus()
        ]);

        if($notification->getStatus() == 3) {
          // Liberar o pedido do usuário..., atualizar o status do pedido para em separação
          //Notificar o usuário que o pedido foi pago...
          //Notificar a loja da confirmação do pedido...
        }

        return response()->json([], 204);

      } catch (\Exception $e) {
      $message = env('APP_DEBUG') ? $e->getMessage() : '';

        return response()->json(['error' => $message], 500);
      }
      */
    }


  
    private function makePagSeguroSession()

    { 
        //não tem cessão
      if(!session()->has('pagseguro_session_code')) {

      //busca no api - retorna o codigo criado no pagseguro
      $sessionCode = \PagSeguro\Services\Session::create(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
      );
        //coloca este codigo de cessão na nossa cessão
      return session()->put('pagseguro_session_code', $sessionCode->getResult());
       }
    }
     
}
