<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\User;

class UsersReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct($userReport)
    {
        $this->userReport = $userReport;
        // $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $userData = User::all();
        $userData = [];
        foreach ($this->userReport as $key => $value) {
            $data['name'] = $value['name'];
            $data['email'] = !empty($value['email']) ? $value['email']:'-';
            $data['mobile_number'] = !empty($value['mobile_number']) ? $value['mobile_number']:'-' ;
            $data['bvn'] = !empty($value['user_detail']['bvn']) ? $value['user_detail']['bvn']:'-' ;
            $data['bank_name'] = !empty($value['user_detail']['bank_name']) ? $value['user_detail']['bank_name']:'-' ;
            $data['employer_detail'] = !empty($value['user_detail']['employer_detail']) ? $value['user_detail']['employer_detail']:'-' ;
            $data['address'] = !empty($value['user_detail']['address']) ? $value['user_detail']['address']:'-' ;
            $data['user_loan_count_count'] = !empty($value['user_loan_count_count']) ? $value['user_loan_count_count']:'-' ;
            $data['invest_loan_count_count'] = !empty($value['invest_loan_count_count']) ? $value['invest_loan_count_count']:'-' ;
            $userData[] = $data;
        }
        // print_r($this->userReport);die;
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
            'BVN',
            'Bank Name',
            'Employment',
            'Location',
            'Total Loans',
            'Total Invest',
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
