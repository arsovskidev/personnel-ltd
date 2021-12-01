<?php

namespace App\Imports;

use App\Models\Call;
use App\Models\Client;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CallsImport implements ToModel, WithStartRow, SkipsOnFailure, WithValidation, WithHeadingRow
{
    use Importable, SkipsFailures;

    /**
     * Given CSV data format:
     * row = [
     * 'user',
     * 'client',
     * 'client_type',
     * 'date',
     * 'duration',
     * 'type_of_call',
     * 'external_call_score',
     * ]
     */

    /**
     * Here we do validation of the rows:
     * The User field is required.
     * The Client field is required.
     * The Client Type field is required and needs to be Carer or Nurse.
     * The Date field is required.
     * The Duration field is required and needs to be numeric.
     * The Type Of Call field is required and needs to be Incoming or Outgoing.
     * The External Call Score is required and needs to be numeric.
     * @return array
     */
    public function rules(): array
    {
        return [
            'user' => 'required',
            'client' => 'required',
            'client_type' => 'required|in:Carer,Nurse',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'duration' => 'required|numeric',
            'type_of_call' => 'required|in:Incoming,Outgoing',
            'external_call_score' => 'required|numeric',
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        /**
         * Check if the user and client exists in the database,
         * if not then create them with the name in the row.
         * For the client, add the type.
         */
        $user = User::firstOrCreate(['name' => $row['user']]);
        $client = Client::firstOrCreate(['name' => $row['client'], 'type' => $row['client_type']]);

        // Get the id's from the user and client.
        $user_id = $user->id;
        $client_id = $client->id;

        // Calling the function to check for duplicate call.
        if (!$this->isDuplicateCall($user_id, $client_id, $row['duration'], $row['external_call_score'], $row['type_of_call'], $row['date'])) {

            // Create new Call with the ids for the user and client,
            // and with all other data in the row.
            return new Call([
                'user_id' => $user_id,
                'client_id' => $client_id,
                'date' => $row['date'],
                'duration' => $row['duration'],
                'type' => $row['type_of_call'],
                'score' => $row['external_call_score'],
            ]);
        }
    }

    /**
     * Skip the first / start from second row because the first one is the titles.
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Checking if there is A Call in database with the given params, if yes then it means there is duplicate.
     * If there is a duplicate, it will return true.
     * @param string $date The date from the row.
     * @param string $user_id The user id.
     * @param string $client_id The client id.
     * @param string $duration The duration from the row.
     * @param string $score The score from the row.
     * @param string $type The type from the row.
     * 
     * @return bool
     */
    public function isDuplicateCall(string $user_id, string $client_id, string $duration, string $score, string $type, string $date): bool
    {
        $duplicate = Call::where('user_id', $user_id)->where('client_id', $client_id)->where('date', $date)->first();

        // If there is duplicate, throw validation exception with message.
        if (!is_null($duplicate)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['It appears that you have duplicate call logs in your file, rolling back everything.']);
        }

        return false;
    }
}
