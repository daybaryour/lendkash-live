<?php

use App\Models\Setting;
use App\Models\LoanEmi;

/**
 * Get admin loan interest rate
 */
function getAdminLoanCommission()
{
    $setting = Setting::where('type', 'commission_for_loan_request')->first();
    return $setting;
}
/**
 * Get admin loan interest rate
 */
function getAdminWalletBankCommission()
{
    $setting = Setting::where('type', 'wallet_commission_to_bank_account')->first();
    return $setting['value'];
}

/**
 * Received amount percentage
 */
function receivedAmountPercent($totalAmount, $receiveAmount)
{
    // return $totalAmount;
    if($receiveAmount>0){
        $a = $receiveAmount * 100;
        return $a / $totalAmount;
    } else {
        return 0;
    }
}

/**
 * Total amount with interest (SIMPLE INTEREST SI)
 */
function amountWithInterest($totalAmount, $interest, $time)
{
    $r = $interest / 100;
    $t = $time / 12;
    $total =  (1 + $r * $t);
    $SI = $total * $totalAmount;
    return $SI;
}

/**
 * Total EMI
 */

function getTotalEmiByTerm($term, $frequency){
    if($frequency=="monthly"){
        return $term;
    }

    if($frequency=="weekly"){
        return $term*4;
    }
}

/**
 * Get Admin Commission on EMI
 */
function getAdminCommission($interestAmount, $interest)
{
    $comm = ($interestAmount * $interest)/100;
    return $comm;
}
/**
 * Get Lender Commission on EMI
 */
function getLenderEmiCommission($loanAmount,$lenderAmount,$loanEmi)
{
    $lenderPercent = ($lenderAmount * 100)/$loanAmount;
    $lenderCommission = ($loanEmi * $lenderPercent)/100;
    return $lenderCommission;
}
/**
 * Get invest maturity complete percent by days
 */
function investMaturityPercent($startDate,$endDate)
{
    $currentDate = date('Y-m-d');
    $currentDate = new DateTime($currentDate);
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);
    $totalDays = $startDate->diff($endDate);
    $completeDays = $startDate->diff($currentDate);
    $percent = ($completeDays->days*100)/$totalDays->days;
    return round($percent);
}

