<?php

namespace App\Imports;

use App\Enums\CampaignStatus;
use App\Models\Campaign;
use App\Models\Pitch;
use App\Models\SubPitch;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CampaignsImport implements ToArray, WithHeadingRow
{
    /**
     * @param  array  $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function array(array $array): void
    {
        foreach ($array as $each) {
            try {
                $pitchName = $each['ten_san'];
                $city = $each['dia_diem'];
                $date = Date::excelToDateTimeObject($each['ngay_da'])->format('Y-m-d');
                $start = Date::excelToDateTimeObject($each['gio_bat_dau'])->format('h:i:s');
                $end = Date::excelToDateTimeObject($each['gio_ket_thuc'])->format('h:i:s');


                $pitch = Pitch::firstOrCreate([
                    'name' => $pitchName,
                ], [
                    'city' => $city,
                    'country' => 'Vietnam',
                ]);

                $sub_pitch = SubPitch::firstOrCreate([
                    'pitch_id' => $pitch->id,
                ], [
                    'image' => '1',
                    'name' => 'Sân',
                    'number_rentered' => 1,
                    'price_per_hour' => 1,
                    'type_id' => 2,
                ]);

                Campaign::create([
                    'campaign_title' => $pitchName. $sub_pitch['name'] .'-'.$city,
                    'pitch_id' => $pitch->id,
                    'sub_pitch_id' => 1,
                    'date' => $date,
                    'start_time' => $start,
                    'end_time' => $end,
                    'status' => CampaignStatus::AWAITING_TO_USE,
                ]);
            } catch (\Throwable $e) {
                dd($each);
            }
        }
    }
}
