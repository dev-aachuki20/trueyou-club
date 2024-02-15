<?php

namespace App\Exports;

use DB;
use App\Models\Quote;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class QuoteExcelReportExport implements FromQuery, WithHeadings,WithMapping, WithStyles, WithColumnWidths
{
    protected $filterStartDate, $filterEndDate, $search, $quote_id, $sortColumnName,$sortDirection;

    public function __construct($quote_id,$filterStartDate, $filterEndDate, $search,$sortColumnName,$sortDirection)
    {
        $this->quote_id = $quote_id;
        $this->filterStartDate = $filterStartDate;
        $this->filterEndDate = $filterEndDate;
        $this->search = $search;
        $this->sortColumnName = $sortColumnName;
        $this->sortDirection = $sortDirection;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 16,
            'C' => 13,
            'D' => 11,
            'E' => 10,
        ];
    }

    public function headings(): array
    {
        return [
            trans('cruds.mis_reports.fields.date'),
            trans('cruds.mis_reports.fields.total_completed'),
            trans('cruds.mis_reports.fields.total_skipped'),
            trans('cruds.mis_reports.fields.total_leave'),
            trans('cruds.mis_reports.fields.total_user'),
        ];

    }

    public function query()
    {
        $searchValue = $this->search;
       
        $startDate = $this->filterStartDate ? $this->filterStartDate->startOfDay() : null;
        $endDate = $this->filterEndDate ? $this->filterEndDate->endOfDay() : null;

        $allReports = Quote::query()->withCount([
            'users as total_completed_users' => function ($query) {
                $query->whereHas('quotes', function ($subQuery) {
                    $subQuery->where('quote_user.status', 'completed');
                });

                $query->whereHas('roles', function ($subQuery) {
                    $subQuery->where('id', config('constants.role.user'));
                });
            },
            'users as total_skipped_users' => function ($query) {
                $query->whereHas('quotes', function ($subQuery) {
                    $subQuery->where('quote_user.status', 'skipped');
                });
                $query->whereHas('roles', function ($subQuery) {
                    $subQuery->where('id', config('constants.role.user'));
                });
            },
            // 'users as total_leave_users' => function ($query) {
            //     $query->whereHas('roles', function ($subQuery) {
            //         $subQuery->where('id', config('constants.role.user'));
            //     })->whereDoesntHave('quotes');
            // }
        ])
        ->where('id',$this->quote_id)
        ->where(function ($query) use ($searchValue) {
            $query->whereRaw("date_format(created_at, '" . config('constants.search_full_date_format') . "') like ?", ['%' . $searchValue . '%']);
        });

        if(!is_null($startDate) && !is_null($endDate)){
            $allReports = $allReports->whereBetween('created_at', [$startDate, $endDate]);
        }

        $allReports =  $allReports->orderBy($this->sortColumnName, $this->sortDirection);

        return $allReports;
    }


    public function map($row): array
    {
        $userIds = DB::table('quote_user')->where('quote_id',$row->id)->pluck('user_id')->toArray();
        $total_leave_users = DB::table('users')->whereNotIn('id',$userIds)->where('deleted_at',null)->count();
        $total_users = DB::table('users')->where('deleted_at',null)->count();
  
        return [
            convertDateTimeFormat($row->created_at,'fulldate'),
            !empty($row->total_completed_users) ? $row->total_completed_users : '0',
            !empty($row->total_skipped_users) ? $row->total_skipped_users : '0',
            !empty($total_leave_users) ? $total_leave_users : '0',
            !empty($total_users) ? $total_users : '0',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the first row (headings) to make them bold
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }
}
