<?php

use Ladesk\Ladesk;

class CartTest extends PHPUnit_Framework_TestCase
{
    private function getApi()
    {
        $api_url = getenv('API_URL');
        $api_key = getenv('API_KEY');
        if(empty($api_key) || empty($api_url)) {
            throw new Exception('Set ENV variables for tests');
        }
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

    public function testDepartments()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->departments();
        $this->assertArrayHasKey('departmentid', $result[0]);
    }

}
