<?php

namespace App\Helpers;
use App\Models\Clientes;
use App\Models\Pedidos_pagamentos;
use App\Models\Pedidos;
use App\Models\Lojas_gateway;
use App\Models\Formas_pagamento;
use App\Models\Pedidos_situacao;
class Functions
{

   /**
     *Responsavel para realizar a consultas com criterios.
     *
     * @param  array  $pedido_pag
     * @param  array  $pedido
     * @param  array  $cliente
     * @return  array  $updater 
     */
  public static function search_payment($pedido_pag, $pedido, $cliente)
  {
    $servidor = 'https://api11.ecompleto.com.br/exams/processTransaction?accessToken=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdG9yZUlkIjoiNCIsInVzZXJJZCI6IjkwNDAiLCJpYXQiOjE2NzQxNTQ2OTQsImV4cCI6MTY3NDg3NDc5OX0.2Y0BIi_UYJ5Vtt9LRghvB64zaR1JJHZ8LVy6_wv3cQ8';

    $data =  date( 'my' , strtotime( $pedido_pag['vencimento'] ) );

    $dados = '{"external_order_id": ' . $pedido['id'] . ',"amount":' . $pedido['valor_total'] . ',"card_number": "' . $pedido_pag['num_cartao'] . '","card_cvv": "' . $pedido_pag['codigo_verificacao'] . '","card_expiration_date":"' .$data. '","card_holder_name": "' . $pedido_pag['nome_portador'] . '","customer": {"external_id": "' . $cliente['id'] . '","name": "' . $cliente['nome'] . '","type": "individual","email":"' . $cliente['email'] . '","documents": [{"type": "cpf","number": "' . $cliente['cpf_cnpj'] . '"}],"birthday": "' . $cliente['data_nasc'] . '"}}';

    $dados_arry= json_decode($dados);
    $dados_json = json_encode($dados_arry);
     
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $servidor);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dados_json
         
);

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $resoposta = json_decode($result);

    $updater=Pedidos_pagamentos::findOrFail($pedido_pag['id']);
    $updater['retorno_intermediador'] = Functions::tirarAcentos($resoposta->Message);
    $updater['data_processamento'] = date("d-m-Y H:i:s");
    $updater->save(); 

    if($resoposta->Message=='Pagamento Recusado. Cartão sem crédito disponível.'){
    $updater_pedidos=Pedidos::findOrFail($pedido['id']);
    $updater_pedidos['id_situacao'] = 3; 
    $updater_pedidos->save();
    }

    return $updater;
  }
  public static function search_form_payment()
  {
  $forma_pagamento=[];
  $forma_pagamentos = Formas_pagamento::all(); 

  foreach($forma_pagamentos as $key => $value){
      $name = Functions::tirarAcentos($value->descricao);
      $value->descricao = $name;
      $forma_pagamento[ $name]=$value;
  }

    return $forma_pagamento;
}
   /**
     *Responsavel para criar array com indices de Pedido Situacao .
     *
     * @param  array  $pedido_pag
     * @param  array  $pedido
     * @param  array  $cliente
     * @return \Illuminate\Http\Response
     */
    public static function search_status_request()
{
$pedidos_situacao=[];
$pedidos_situacaos = Pedidos_situacao::all(); 

foreach($pedidos_situacaos as $key => $value){
    $pedidos_situacao[$value->descricao]=$value;
}

  return $pedidos_situacao;
}
    /**
     *Responsavel para criar array com indices de Pedido Pagamento .
     *
     * @param  array  $pedido_pag
     * @param  array  $pedidos_pagamentos
     * @return array  $pedido_pag 
     */
    public static function search_payment_requests()
  {
  $pedidos_pag=[];
  $pedidos_pagamentos = Pedidos_pagamentos::all(); 

  foreach($pedidos_pagamentos as $key => $value){
      $pedidos_pag[$value->id_pedido]=$value;
  }

    return $pedidos_pag;
}
    /**
     *Responsavel para criar array com indices de Clientes .
     *
     * @param  array  $cliente
     * @param  array  $clientes
     * @return array  $cliente 
     */
public static function search_clients()
{
$cliente=[];
$clientes = Clientes::all(); 

foreach($clientes as $key => $value){
    $cliente[$value->id]=$value;
}

  return $cliente;
}
    /**
     *Responsavel para criar array com indices de Lojas Geteway .
     *
     * @param  array  $id_loja
     * @param  array  $lojas 
     * @return array  $id_loja
     */
public static function lojas_gateway()
{
$id_loja=[];
$lojas = lojas_gateway::Where('id_gateway', '=', '1')->get();
        
foreach($lojas as $key => $value){
    $id_loja[$value->id_loja]=$value->id_loja;
}
  return $id_loja;
}
  public  static function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}
 
}



