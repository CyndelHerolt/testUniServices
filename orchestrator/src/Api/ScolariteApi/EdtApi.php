<?php
namespace App\Api\ScolariteApi;

use Symfony\Component\HttpClient\HttpClient;
use App\DataTransformer\EdtPlanningDataTransformer;

class EdtApi
{
    private EdtPlanningDataTransformer $edtPlanningDataTransformer;

    public function __construct(EdtPlanningDataTransformer $edtPlanningDataTransformer)
    {
        $this->edtPlanningDataTransformer = $edtPlanningDataTransformer;
    }

    public function getEdtWeek(string $token, array $datas): array
    {
        $debut = new \DateTime($datas['start']);
        $fin = new \DateTime($datas['end']);

        $debut = $debut->format('Y-m-d');
        $fin = $fin->format('Y-m-d');

        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8002/api/edt_plannings?date\[after\]='.$debut.'&date\[before\]='.$fin, [
            'headers' => [
                'Authorization' => $token,
            ],
        ]);

        $content = $response->toArray();

        if (!isset($content['member']) || !is_array($content['member'])) {
            throw new \Exception('Invalid response structure');
        }

        $members = $content['member'];

        $transformedData = array_map(function($item) {
            if (!is_array($item)) {
                throw new \InvalidArgumentException('Expected array, got ' . gettype($item));
            }
            return $this->edtPlanningDataTransformer->transform($item);
        }, $members);

        return $transformedData;
    }
}
