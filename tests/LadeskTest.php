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
        $this->assertArrayHasKey('name', $companies[0]);
    }

    public function testAgent()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getAgentOnlineStatus();
        $this->assertArrayHasKey('username', $result[0]);
    }

    public function testDepartments()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getDepartments();
        $this->assertArrayHasKey('departmentid', $result[0]);
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

}
