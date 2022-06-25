<?php

namespace Ant\StatementAnalyzer\Imports;

use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StatementImport implements ToModel, WithStartRow, WithHeadingRow, WithValidation, SkipsOnFailure {

    use Importable, SkipsFailures;
    
    private $rows = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {
        ++$this->rows;
        
        return new Statement([
            'importid' => request('import_ref'),
            'account_number' => request('account_number'),
            'date' => $row['date'] ? Carbon::createFromFormat('d-M-Y', trim($row['date']))->format('Y-m-d') : '',
            'description' => $row['transaction_details'] ?? '',
            'money_in_currency' => $row['money_in_currency'] ?? '',
            'money_in' => $row['money_in'] ?? '',
            'money_out_currency' => $row['money_out_currency'] ?? '',
            'money_out' => $row['money_out'] ?? '',
            'balance_currency' => $row['balance_currency'] ?? '',
            'balance' => $row['balance'] ?? '',
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => [
                'required',
            ],
            'transaction_details' => [
                'required',
            ],
            'balance' => [
                'required',
            ],   
        ];
    }
    
    public function headingRow(): int
    {
        return 10;
    }

    /**
     * we are ignoring the header and so we will start with row number (2)
     * @return int
     */
    public function startRow(): int {
        return 11;
    }


    /**
     * lets count the total imported rows
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
