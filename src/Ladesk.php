<?php

namespace Ladesk;

use GuzzleHttp\Client;

class Ladesk
{

    public function __construct($url, $key)
    {
        $this->api_key = $key;
        $this->client = new Client(array(
            'base_uri' => $url.'/api/index.php',
            'timeout' => 5,
        ));
    }

    public function companies()
    {
        $result = $this->call('companies');
        return $result['companies'];
    }

    public function departments()
    {
        $result = $this->call('departments');
        return $result['departments'];
    }

    public function agent($id)
    {
        return $this->call('agents/' . $id);
    }

    public function agentOnlineStatus()
    {
        $result = $this->call('onlinestatus/agents');
        return $result['agentsOnlineStates'];
    }

    private function call($url)
    {
        $params = array(
            'query' => array(
                'handler' => $url,
                'apikey' => $this->api_key,
            )
        );
        $response = $this->client->request('GET', '', $params);
        $code = $response->getStatusCode();
        if ($code != 200) {
            throw new \ErrorException('status occurred: ' . $code);
        }
        $json = (string)$response->getBody();
        $decoded = json_decode($json, 1);
        if (isset($decoded['response']['status']) && $decoded['response']['status'] == 'ERROR') {
            throw new \ErrorException('error occurred: ' . $decoded['response']['errormessage']);
        }
        return $decoded['response'];
    }
}