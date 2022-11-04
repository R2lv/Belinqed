<?php

namespace App\Http\Controllers;

use App\Http\Lib\Billing\UFCPayment;
use App\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct() {
        $this->middleware('auth:company');
    }

    public function vtb_success(Request $request) {
        /* @var $payment UFCPayment */
        $trans_id = $request->get("trans_id");
        $res = self::check_payment($trans_id);
        if($res["success"]) {
            return redirect("/company/dashboard#my-package");
        } else {
            return $this->failure($res["result"]);
        }
    }
    public function vtb_fail(Request $request) {
        dd($request->all());

    }

    public static function check_payment($trans_id) {
        $payment = app('payment:vtb');
        $result =  $payment->check_transaction($trans_id);
        if(isset($result["RESULT_CODE"]) && $result["RESULT_CODE"] === UFCPayment::CODE_TRANSACTION_SUCCESS) {
            $transaction = Transaction::query()->with('companyPackage')->where("trans_id", $trans_id)->first();
            $transaction->update(['completed'=>1]);

            $transaction->companyPackage->update(['paid'=>1]);

            return ['success'=>true, 'result'=>$transaction];
        }

        return ['success'=>false, 'result'=>$result];
    }
}