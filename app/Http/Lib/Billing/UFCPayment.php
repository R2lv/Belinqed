<?php


namespace App\Http\Lib\Billing;


use GuzzleHttp\Client;
use View;

class UFCPayment {
    const CURRENCY_GEL = 981,
          CURRENCY_USD = 840,
          CURRENCY_RUB = 643,
          CURRENCY_EUR = 978;

    const CODE_REVERSAL_SUCCESS = "400",
          CODE_TRANSACTION_SUCCESS = "000",
          CODE_END_DAY_SUCCESS = "500";

    private $apiMerchantHandler, $apiClientHandler;

    public function __construct($certPath, $certPass, $apiMerchantHandler="https://securepay.ufc.ge:18443/ecomm2/MerchantHandler", $apiClientHandler="https://securepay.ufc.ge:18443/ecomm2/ClientHandler") {
        $this->apiMerchantHandler = $apiMerchantHandler;
        $this->apiClientHandler = $apiClientHandler;

        $this->http = new Client([
            'verify'=>false,
            'cert'=>[$certPath, $certPass]
        ]);
    }

    public function start_transaction($amount, $description, $currency=self::CURRENCY_GEL, $language="GE", $ip_addr=false) {
        if(!$ip_addr) $ip_addr = request()->ip();
        $req = $this->http->post($this->apiMerchantHandler, [
            'form_params'=>[
                'command'=>'v',
                'amount'=>$amount,
                'currency'=>$currency,
                'client_ip_addr'=>$ip_addr,
                'language'=>$language,
                'description'=>$description,
                'msg_type'=>"SMS"
            ]
        ]);

        return $this->parse_content($req->getBody()->getContents());
    }

    /**
     * @return View|string
     * @param string $transaction_id ID of the transaction
     * You should return the value of this method to redirect user
     */
    public function redirect_client($transaction_id, $view=false) {
        if($view) {
            return view($view, ['transaction_id'=>$transaction_id]);
        }
        return <<<HTML
<form method="post" action="{$this->apiBase}{$this->apiClientHandler}">
    <input type="hidden" name="trans_id" value="{$transaction_id}">
</form>
<script>document.querySelector("form").submit();</script>
HTML;
    }

    public function check_transaction($transaction_id) {
        $req = $this->http->post($this->apiMerchantHandler, [
            'form_params'=>[
                'command'=>'c',
                'trans_id'=>$transaction_id
            ]
        ]);
        return $this->parse_content($req->getBody()->getContents());
    }

    public function transaction_reverse($transaction_id, $amount) {
        $req = $this->http->post($this->apiMerchantHandler, [
            'form_params'=> [
                'command'=>'r',
                'trans_id'=>$transaction_id,
                'amount'=>$amount
            ]
        ]);

        return $this->parse_content($req->getBody()->getContents());
    }

    public function end_day() {
        $req = $this->http->post($this->apiMerchantHandler, [
            'form_params'=> [
                'command'=>'b'
            ]
        ]);

        return $this->parse_content($req->getBody()->getContents());
    }

    public function getRedirecetUrl() {
        return $this->apiClientHandler;
    }

    private function parse_content($content) {
        $res = [];
        $lines = explode(PHP_EOL, $content);
        foreach($lines as $line) {
            $kv = explode(":", $line);
            if(count($kv) == 2)
                $res[trim($kv[0])] = trim($kv[1]);
        }

        return $res;
    }
}