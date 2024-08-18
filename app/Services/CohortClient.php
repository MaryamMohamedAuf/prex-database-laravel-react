<?
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
class CohortClient
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8001', // URL of the cohort service
        ]);
    }

    public function getCohorts()
    {
        // $response = $this->client->get('/cohorts');

        // $data = json_decode($response->getBody()->getContents(), true);
        //     Log::info('CohortClient Response:', $data);
        //     return $data;
}
}
