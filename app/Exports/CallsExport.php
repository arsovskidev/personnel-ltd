<?php

namespace App\Exports;

use App\Models\Call;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CallsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Setting headings for the output file/document.
     * @return array
     */
    public function headings(): array
    {
        return [
            "User",
            "Client",
            "Client Type",
            "Date",
            "Duration",
            "Type Of Call",
            "External Call Score"
        ];
    }

    /**
     * Accessing relationship values for user_name and client_name and mapping them all.
     * @param $call
     * @return array
     */
    public function map($call): array
    {
        return [
            $call->user->name,
            $call->client->name,
            $call->client->type,
            $call->date,
            $call->duration,
            $call->type,
            $call->score,
        ];
    }
    /**
     * Getting collection with all call models.
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Call::all();
    }
}
