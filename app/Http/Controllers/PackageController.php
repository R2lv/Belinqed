<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyPackage;
use App\Http\Lib\Billing\UFCPayment;
use App\Package;
use App\Transaction;

class PackageController extends Controller
{
    public function __construct() {
        $this->middleware("auth:company", ['except' => ['index']]);
    }

    public function index() {
        return $this->success(Package::query()->where("public",1)->get());
    }

    public function show() {
        return $this->success(auth("company")->user()->company->package);
    }

    public function buy($id) {
        /* @var $company Company */
        $package = Package::query()->find($id);
        $company = auth('company')->user()->company;

        if(!$package) return $this->failure("Package not found");
        if($company->package) {
            if($company->package->vacancies) {
                return $this->failure("You already have a package with {$company->package->vacancies} vacancies available");
            }
        }

        /* @var $payment UFCPayment */
        $payment = app('payment:vtb');

        $description = "Belinqed|".$package->name;

        $res = $payment->start_transaction($package->price*100, $description);

        if(isset($res["TRANSACTION_ID"])) {

            $company_package = new CompanyPackage([
                'name_en'=>$package->name_en,
                'name_ka'=>$package->name_ka,
                'vacancies'=>$package->vacancies,
                'candidates'=>$package->candidates,
                'days_active'=>$package->days_active,
                'price'=>$package->price,
                'currency'=>$package->currency,
                'paid'=>0
            ]);

            $company->packages()->save($company_package);

            $transaction = new Transaction([
                'trans_id'=>$res["TRANSACTION_ID"],
                'price'=>$package->price,
                'description'=>$description,
                'company_package_id'=>$company_package->id
            ]);
            $company->transactions()->save($transaction);


            return $this->success([
                'redirect_url'=>$payment->getRedirecetUrl(),
                'trans_id'=>$res["TRANSACTION_ID"]
            ]);
        } else {
            return $this->failure("Unknown error");
        }
    }
}
