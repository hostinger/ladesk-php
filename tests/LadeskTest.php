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

        $data = array(
            'name' => 'brand new tag name',
            'color' => '',
            'bg_color' => ''
        );
//        $result = $ladesk->addTag($data);

        $result = $ladesk->getTags();
        $this->assertArrayHasKey('name', $result[0]);

//        $result = $ladesk->changeTag('4247', $data);

        $id = $result[0]['id'];
        $result = $ladesk->getTag($id);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('color', $result);
        $this->assertArrayHasKey('bg_color', $result);

        $result = $ladesk->deleteTag($id);

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

//        $result = $ladesk->unassignTagFromConversation($id, 'paid');

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

        $data = array(
            'agentidentifier' => '',
            'useridentifier' => '',
            'department' => 'f16239ed',
            'note' => 'this is a note'
        );
//        $result = $ladesk->transferConversation($id, $data);

        $data = array(
            'useridentifier' => '',
            'note' => 'this is a deletion note'
        );
//        $result = $ladesk->deleteConversation($id, $data);

    }

    public function testCustomers()
    {
        $ladesk = $this->getApi();
        $param = array(
            'email' => 'hisemail@mail.domain'
        );
        $result = $ladesk->getCustomers(); //var_dump($result);

        $id = $result[14]['contactid'];

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

        //$result = $ladesk->addCustomerToGroup($id, 'non-VIP2'); var_dump($result);

        $result = $ladesk->getCustomerGroups($id);
        $this->assertArrayHasKey('groupid', $result[0]);
        $this->assertArrayHasKey('groupname', $result[0]);

        $data = array(
            'email' => 'hisemail2@mail.domain',
            'phone' => '453',
            'name' => 'Fname2 Lname2',
            'role' => 'R',
            'password' => 'hispassword',
            'note'   =>  'lovely customer2',
            'send_registration_mail' => 'N'
        );

//        $result = $ladesk->registerCustomer($data); var_dump($result);


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

    public function testSuggestionCategories()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getSuggestionCategories();
        /* no suggestion categories just yet
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('path', $result[0]);*/
    }

    public function testChatAgentsAvailabilityReport()
    {
        $ladesk = $this->getApi();

        $params = array(
            'date_from' => '',
            'date_to' => '',
            'columns' => '',
            'limicount' => '',
            'limitfrom' => '',
            'departmentid' => '',
            'agentid' => ''
        );
        $result = $ladesk->getChatAgentsAvailabilityReport();
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('userid', $result[0]);
        $this->assertArrayHasKey('firstname', $result[0]);
        $this->assertArrayHasKey('lastname', $result[0]);
        $this->assertArrayHasKey('contactid', $result[0]);
        $this->assertArrayHasKey('departmentid', $result[0]);
        $this->assertArrayHasKey('department_name', $result[0]);
        $this->assertArrayHasKey('hours_online', $result[0]);
        $this->assertArrayHasKey('from_date', $result[0]);
        $this->assertArrayHasKey('to_date', $result[0]);
    }

    public function testChatsAvailabilityAndLoadReport()
    {
        $ladesk = $this->getApi();

        $params = array(
            'date_from' => '',
            'date_to' => '',
            'limicount' => '',
            'limitfrom' => '',
            'departmentid' => '',
            'agentid' => ''
        );
        $result = $ladesk->getChatsAvailabilityReport();
        $this->assertArrayHasKey('date', $result[0]);
        $this->assertArrayHasKey('mins', $result[0]);
        $this->assertArrayHasKey('pct', $result[0]);

        $result = $ladesk->getChatsLoadReport();
        $this->assertArrayHasKey('date', $result[0]);
        $this->assertArrayHasKey('avgQueue', $result[0]);
        $this->assertArrayHasKey('maxQueue', $result[0]);
        $this->assertArrayHasKey('minQueue', $result[0]);
        $this->assertArrayHasKey('avgSlots', $result[0]);
        $this->assertArrayHasKey('maxSlots', $result[0]);
        $this->assertArrayHasKey('minSlots', $result[0]);
        $this->assertArrayHasKey('avgService', $result[0]);
        $this->assertArrayHasKey('maxService', $result[0]);
        $this->assertArrayHasKey('minService', $result[0]);
    }

}
