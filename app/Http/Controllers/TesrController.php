<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Http\Request;

class TesrController extends Controller
{
    public function sendMessages()  {

        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://graph.facebook.com/v15.0/103426542608323/messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "messaging_product": "whatsapp",
            "to": "97333506287",
            "type": "template",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer EAAIq3ZCF6DSsBAIywNdaUaI4FvmHGbiDNOfdPHbQZBMMu8s9pEPer5HkE9KsEeJOXvQtgQxso5UbZCa4zg4ZCv7K24H6jeRGLPS3du62TYgvQLzaLUmbsbTVVNaMnS4j6DDoggIJzYv7ijOC0eoAcPqFfKFwFIBvISQbv2QEpvcwQkhlceW2yUVDu3kOUTrEyEdAhmVvkAZDZD'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        

    }



    public function sendMessages2()  {
        try{
        $phoneId= '103426542608323';
        $verson = 'v15.0';
$token= 'EAAIq3ZCF6DSsBAIywNdaUaI4FvmHGbiDNOfdPHbQZBMMu8s9pEPer5HkE9KsEeJOXvQtgQxso5UbZCa4zg4ZCv7K24H6jeRGLPS3du62TYgvQLzaLUmbsbTVVNaMnS4j6DDoggIJzYv7ijOC0eoAcPqFfKFwFIBvISQbv2QEpvcwQkhlceW2yUVDu3kOUTrEyEdAhmVvkAZDZD';
$payload = [
    'messaging_product' =>'whatsapp' ,
    'to' => '97333506287' ,
    'type'=> 'template',
    "template" => [
        "name" => "hello_world",
        "language" => [
            "code" => "en_US"
        ]


    ]
    ];
      $message =  Http::withToken($token)->post('https://graph.facebook.com/'.$verson.'/'. $phoneId.'/messages', $payload)->throw()->json();
      return response()->json([
        'success'=> true,
        'data' =>$message
      ],200);
}
catch (Exception $e) {
    return response()->json([
        'success'=> false,
        'error' => $e->getMessage(),
      ],500);

}
    }
    public function verifyWebhook(Request $request){
try{
    $verifytoken ='creativetagwhatsapp1995!';
    $query = $request->query();
    $mode = $query['hub_mode'];
    $token = $query['hub_verify_token'];
    $challenge = $query['cgallenge'];

  if ($mode && $token){
      if ($mode =='subscribe' && $token == $verifytoken){

    return response($challenge,200)->header('content-Type','text/plain');
  }
}


}
catch(Exception $e){
  return response()->json([
    'success'=> false,
    'error' => $e->getMessage(),
  ],500);



}



    }
}
