<?php

declare(strict_types=1);

namespace App\Traits;

trait ParseSyndicationTargets
{
    /**
     * Parse the JSON data of syndication targets.
     *
     * @param  string  $json The syndication targets data encoded in a JSON string
     * @return array
     */
    public function parseSyndicationTargets(string $json): array
    {
        $data = json_decode($json);
        if ($data === null) {
            // could be null, or could be an error
            if (json_last_error() !== 0) {
                throw new JSONParseException;
            }

            return [];
        }

        return collect($data)->map(function ($item) {
            return [
                'uid' => $item->uid,
                'name' => $item->name,
            ];
        })->toArray();
    }
}
