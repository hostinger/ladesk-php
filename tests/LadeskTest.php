<?php

use Ladesk\Ladesk;

class CartTest extends PHPUnit_Framework_TestCase
{
    private function getApi()
    {
        $api_url = getenv('API_URL');
        $api_key = getenv('API_KEY');
        return new Ladesk($api_url, $api_key);
    }

    public function testCompanies()
    {
        $ladesk = $this->getApi();
        $companies = $ladesk->companies();
        $this->assertArrayHasKey('name', $companies[0]);
    }

    public function testAgent()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->agentOnlineStatus();
        $this->assertArrayHasKey('username', $result[0]);
    }

}
