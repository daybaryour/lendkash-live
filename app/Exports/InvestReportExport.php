<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\User;

class InvestReportExport implements FromCollection, WithHeadings, ShouldAutoSize
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
            $data['name'] = !empty($value['user_detail']['name']) ? $value['user_detail']['name']:'-';
            $data['email'] = !empty($value['user_detail']['email']) ? $value['user_detail']['email']:'-';
            $data['mobile_number'] = !empty($value['user_detail']['mobile_number']) ? $value['user_detail']['mobile_number']:'-';
            $data['invest_amount'] = !empty($value['invest_amount']) ? $value['invest_amount']:'-';
            $data['invests_term'] = !empty($value['invests_term']) ? $value['invests_term']:'-';
            $data['interest_rate'] = !empty($value['interest_rate']) ? $value['interest_rate']:'-';
            $data['maturity_amount'] = !empty($value['maturity_amount']) ? $value['maturity_amount']:'-';
            $data['invest_start_date'] = !empty($value['invest_start_date']) ? $value['invest_start_date']:'-';
            $data['invest_end_date'] = !empty($value['invest_end_date']) ? $value['invest_end_date']:'-';
            $data['status'] = !empty($value['status']) ? $value['status']:'-';
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
            'Name',
            'Email',
            'Mobile Number',
            'Amount',
            'Term',
            'Interest',
            'Maturity Amount',
            'Date and time of Invest Deposit',
            'Date and time of Maturity',
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
