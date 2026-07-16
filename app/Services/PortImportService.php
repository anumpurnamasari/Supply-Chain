<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Port;

class PortImportService
{
    public function import()
    {
        $path = storage_path('app/ports/updatedpub150.csv');

        if (!file_exists($path)) {
            return [
                'success' => false,
                'message' => 'CSV file not found.'
            ];
        }

        $handle = fopen($path, 'r');

        $header = fgetcsv($handle);

        $saved = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {

            $data = array_combine($header, $row);

            $country = Country::where(
                'name',
                trim($data['Country Code'])
            )->first();

            if (!$country) {
                $skipped++;
                continue;
            }

            Port::updateOrCreate(

                [

                    'country_id' => $country->id,

                    'name' => trim($data['Main Port Name'])

                ],

                [

                    'city' => null,

                    'latitude' => $data['Latitude'],

                    'longitude' => $data['Longitude'],

                    'status' => $data['Harbor Type'] ?: 'Active',

                    'risk_level' => 'LOW'

                ]

            );

            $saved++;
        }

        fclose($handle);

        return [

            'success' => true,

            'saved' => $saved,

            'skipped' => $skipped

        ];
    }
}
