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

    public function testOverview()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getChatsOverview();
        $this->assertArrayHasKey('visitors', $result[0]);

        $result = $ladesk->getCallsOverview();
        $this->assertArrayHasKey('running', $result[0]);
        $this->assertArrayHasKey('ringing', $result[0]);
        $this->assertArrayHasKey('inqueue', $result[0]);
    }

    public function testApplicationStatus()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getApplicationStatus();
        $this->assertArrayHasKey('liveagentversion', $result);
        $this->assertArrayHasKey('current_server_time', $result);
    }

    public function testTags()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getTags();
        $this->assertArrayHasKey('name', $result[0]);
    }

    public function testCompanies()
    {
        $ladesk = $this->getApi();
        $companies = $ladesk->getCompanies();
        $this->assertArrayHasKey('id', $companies[0]);
        $this->assertArrayHasKey('name', $companies[0]);
        $this->assertArrayHasKey('emails', $companies[0]);
        $this->assertArrayHasKey('datecreated', $companies[0]);

        $id = $companies[0]['id'];
        $company = $ladesk->getCompany($id);
        $this->assertArrayHasKey('id', $company);
        $this->assertArrayHasKey('name', $company);
        $this->assertArrayHasKey('datecreated', $company);
        $this->assertArrayHasKey('language', $company);
        $this->assertArrayHasKey('emails', $company);
        $this->assertArrayHasKey('phones', $company);
    }

    public function testAgentOnlineStatus()
    {
        $ladesk = $this->getApi();
        $onlineAgents = $ladesk->getAgentOnlineStatus();
        $this->assertArrayHasKey('id', $onlineAgents[0]);
        $this->assertArrayHasKey('contactid', $onlineAgents[0]);
        $this->assertArrayHasKey('username', $onlineAgents[0]);
        $this->assertArrayHasKey('firstname', $onlineAgents[0]);
        $this->assertArrayHasKey('lastname', $onlineAgents[0]);
        $this->assertArrayHasKey('avatar_url', $onlineAgents[0]);
        $this->assertArrayHasKey('onlineStatus', $onlineAgents[0]);

        $id = $onlineAgents[0]['id'];
        $agent = $ladesk->getAgent($id);
        $this->assertArrayHasKey('contactid', $agent);
        $this->assertArrayHasKey('userid', $agent);
        $this->assertArrayHasKey('email', $agent);
        $this->assertArrayHasKey('firstname', $agent);
        $this->assertArrayHasKey('lastname', $agent);
        $this->assertArrayHasKey('gender', $agent);
        $this->assertArrayHasKey('role', $agent);
        $this->assertArrayHasKey('authtoken', $agent);
    }

    public function testDepartments()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getDepartments();
        $this->assertArrayHasKey('departmentid', $result[0]);

        $id = $result[0]['departmentid'];
        $agents = $ladesk->getAgentsFromDepartment($id);
        $this->assertArrayHasKey('userid', $agents['agents'][0]);
        $this->assertArrayHasKey('firstname', $agents['agents'][0]);
        $this->assertArrayHasKey('lastname', $agents['agents'][0]);
        $this->assertArrayHasKey('email', $agents['agents'][0]);
        $this->assertArrayHasKey('onlinestatus', $agents['agents'][0]);
        $this->assertArrayHasKey('presetstatus', $agents['agents'][0]);
    }

    public function testConversations()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getConversations();
        $this->assertArrayHasKey('conversationid', $result[0]);

        $id = $result[0]['conversationid'];
        $result = $ladesk->getConversation($id);
        $this->assertArrayHasKey('departmentid', $result);
        $this->assertArrayHasKey('code', $result);

        $result = $ladesk->getConversationMessages($id);
        $this->assertArrayHasKey('groups', $result);

//        $result = $ladesk->assignTagForConversation($id, 'test');

        $result = $ladesk->getConversationTags($id);
        $this->assertArrayHasKey('tags', $result);

//        $result = $ladesk->unassignTagForConversation($id, 'paid');

        $data = array(
            'useridentifier' => '',
            'recipient' => '',
            'department' => '',
            'subject' => 'Testing message via API',
            'message' => 'This message was created via REST API',
            'tag'   =>  'test',
        );
//        $result = $ladesk->createConversation($data);
//        $ladesk->addMessageToConversation($id, 'This is reply from API', 'andrius@hostinger.com');
//        $ladesk->addNoteToConversation($id, 'This is auto note');
//        $ladesk->assignTagForConversation($id, 'test');

    }

    public function testCustomers()
    {
        $ladesk = $this->getApi();
        $param = array(
            'email' => 'hisemail@mail.domain'
        );
        $result = $ladesk->getCustomers($param);
        $this->assertArrayHasKey('customers', $result);

        $id = $result[0]['contactid'];

        $result = $ladesk->getCustomer($id);
        $this->assertArrayHasKey('contactid', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayHasKey('firstname', $result);
        $this->assertArrayHasKey('lastname', $result);
        $this->assertArrayHasKey('authtoken', $result);
        $this->assertArrayHasKey('role', $result);
        $this->assertArrayHasKey('gender', $result);
        $this->assertArrayHasKey('userid', $result);
        $this->assertArrayHasKey('datecreated', $result);
        $this->assertArrayHasKey('note', $result);
        $this->assertArrayHasKey('customfields', $result);
        $this->assertArrayHasKey('uniquefields', $result);

        $data = array(
            'email' => 'hisemail@mail.domain',
            'phone' => '',
            'name' => 'Fname Lname',
            'role' => 'R',
            'password' => 'hispassword',
            'note'   =>  'lovely customer',
            'send_registration_mail' => 'N'
        );

//        $result = $ladesk->registerCustomer($data);


    }

    public function testCustomersGroups()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getCustomersGroups();
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);

        $params = array(
            'name' => 'non-VIP2',
            'color' => '000'
        );
//        $result = $ladesk->addCustomersGroup($params);

        $id = $result[0]['id'];
//        $result = $ladesk->deleteCustomersGroup($id);
        $result = $ladesk->getCustomersGroup($id);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('color', $result);
        $this->assertArrayHasKey('bg_color', $result);

//        $result = $ladesk->changeCustomersGroup('503d', $params);
    }

}
