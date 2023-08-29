<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\User;

class LoanReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct($loanReport)
    {
        $this->loanReport = $loanReport;
        // $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $userData = User::all();
        $userData = [];
        foreach ($this->loanReport as $key => $value) {
            $data['id'] = $value['id'];
            $data['loan_request_amount'] = !empty($value['loan_request_amount']) ? $value['loan_request_amount']:'-';
            $data['loan_interest_rate'] = !empty($value['loan_interest_rate']) ? $value['loan_interest_rate']:'-';
            $data['loan_term'] = !empty($value['loan_term']) ? $value['loan_term']:'-';
            $data['emi_amount'] = !empty($value['emi_amount']) ? $value['emi_amount']:'-';
            $data['total_emi'] = !empty($value['total_emi']) ? $value['total_emi']:'-';
            $data['payment_frequency'] = !empty($value['payment_frequency']) ? $value['payment_frequency']:'-';
            $data['loan_description'] = !empty($value['loan_description']) ? $value['loan_description']:'-';
            $data['loan_status'] = !empty($value['loan_status']) ? $value['loan_status']:'-';
            $userData[] = $data;
        }
        // print_r($this->loanReport);die;
        return collect($userData);
    }

    /*
    * set heading of excel sheet
    */
    public function headings() : array
    {
         return [
            'Request Id',
            'Loan Amount',
            'Loan Interest',
            'Loan Term',
            'Monthly EMI',
            'Total EMI',
            'Payment Frequency',
            'Description',
            'Status',
        ];
    }


    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->styleCells(
    //                 'A1:C1000',
    //                 [
    //                     'alignment' => [
    //                         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                     ],
    //                 ]
    //             );
    //         },
    //     ];
    // }
}
