<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use App\Models\Pedidos; 
use Functions;

class PagcompletoController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $id_loja = [];
 
            $pedidos = Pedidos::all(); 
 
            $lojas = Functions::lojas_gateway();
            $forma_pagamento = Functions::search_form_payment();
            $pedido_situacao = Functions::search_status_request();
            $clientes = Functions::search_clients();
            $pedidos_pag = Functions::search_payment_requests();
  
            foreach($pedidos as $key => $value){
               if (empty($lojas["$value->id_loja"])) {
                // Caso a Variavel seja Vazia
                 }else{
                    if($value->id_loja == $lojas["$value->id_loja"]){
   
                    $number = $value->id;
                    $number_two = $pedidos_pag[$number]['id_pedido'];

                        if ($pedidos_pag[$number]['id_pedido'] == "$number") {
                            if($pedidos_pag[$number]['id_formapagto']== $forma_pagamento['Cartao de Credito']['id'] &&  $value->id_situacao == $pedido_situacao['Aguardando Pagamento']['id']){
                            $resultado = Functions::search_payment($pedidos_pag[$number], $value, $clientes[$value->id_cliente]);
                            $response[] = json_decode($resultado);
                                            
                            }
                        }  
                    }
                }   
            }

        return response()->json(['success' => true, 'message' => $response ?? '']);
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
