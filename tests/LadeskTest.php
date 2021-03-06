<?php

class LadeskTest extends PHPUnit_Framework_TestCase
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

    public function testCreateCustomer()
    {
//        $ladesk = $this->getApi();
//        $customer = $ladesk->getCustomerByEmail('paulius.putna@gmail.com');
//        var_dump($customer);
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
            'name' => 'IMPORTED',
            'color' => '',
            'bg_color' => ''
        );
//       $result = $ladesk->addTag($data);

        $result = $ladesk->getTags();
        $this->assertArrayHasKey('name', $result[0]);

//        $result = $ladesk->changeTag('4247', $data);

        $id = $result[0]['id'];
        $result = $ladesk->getTag($id);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('color', $result);
        $this->assertArrayHasKey('bg_color', $result);

//        $result = $ladesk->deleteTag($id);

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

    public function testDepartmentOnlineStatus()
    {
        $ladesk = $this->getApi();
        $onlineDepartmens = $ladesk->getDepartmentOnlineStatus();
        $this->assertArrayHasKey('id', $onlineDepartmens[0]);
        $this->assertArrayHasKey('name', $onlineDepartmens[0]);
        $this->assertArrayHasKey('onlineStatus', $onlineDepartmens[0]);
        $this->assertArrayHasKey('presetStatus', $onlineDepartmens[0]);
        $this->assertArrayHasKey('chat_count', $onlineDepartmens[0]);
        $this->assertArrayHasKey('new_count', $onlineDepartmens[0]);
        $this->assertArrayHasKey('customer_reply_count', $onlineDepartmens[0]);
        $this->assertArrayHasKey('total_count', $onlineDepartmens[0]);
        $this->assertArrayHasKey('max_count', $onlineDepartmens[0]);

        $id = $onlineDepartmens[0]['id'];
        $department = $ladesk->getDepartment($id);
        $this->assertArrayHasKey('departmentid', $department);
        $this->assertArrayHasKey('name', $department);
        $this->assertArrayHasKey('description', $department);
        $this->assertArrayHasKey('onlinestatus', $department);
        $this->assertArrayHasKey('presetstatus', $department);
        $this->assertArrayHasKey('deleted', $department);
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
        $result = $ladesk->getConversation('fc438298');
//        $result = $ladesk->setConversationOpen('fc438298'); var_dump($result);

        $this->assertArrayHasKey('departmentid', $result);
        $this->assertArrayHasKey('code', $result);

        $result = $ladesk->getConversationMessages($id);
        $this->assertArrayHasKey('groups', $result);

//        $result = $ladesk->assignTagForConversation($id, 'test');

        $result = $ladesk->getConversationTags($id);
        $this->assertArrayHasKey('tags', $result);

        $data = array(
            'customfields' => '[{"code":"varsymbol","value":"test"}]'
        );
        //$result = $ladesk->addCustomFieldToConversation('fc438298', $data);

//        $result = $ladesk->deleteCustomFieldFromConversation($id);

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
//        $ladesk->addMessageToConversation('fc438298', 'This is reply from API', 'andrius@hostinger.com');
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
//        $result = $ladesk->deleteConversation('fc438298', $data); var_dump($result);

    }

    public function testCustomers()
    {
        $ladesk = $this->getApi();
        $param = array(
            'email' => 'hisemail@mail.domain'
        );
        $result = $ladesk->getCustomers(); //var_dump($result);

        $id = $result[0]['contactid'];

        $data = array(
            'customfields' => json_encode(array('a', 'b', 'c', 'd'))
        );
//        $result = $ladesk->addCustomFieldToCustomer($id, $data);

        $data = array(
            'code' => 'b'
        );
//        $result = $ladesk->deleteCustomFieldFromCustomer($id, $data);

        $result = $ladesk->getCustomer('feelfree@hotbox.ru');var_dump($result);
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

        //$result = $ladesk->getCustomerGroups($id);
        //$this->assertArrayHasKey('groupid', $result[0]);
        //$this->assertArrayHasKey('groupname', $result[0]);

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

//        $result = $ladesk->deleteCustomerFromGroup('hisemail2@mail.domain', 'non-VIP2');

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

    public function testReports()
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
        $result = $ladesk->getChatAgentAvailabilityReport();
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

        $result = $ladesk->getCallsAvailabilityReport();
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

        $result = $ladesk->getChatsSLAComplianceReport();
        $this->assertArrayHasKey('date', $result[0]);
        $this->assertArrayHasKey('fulfilled', $result[0]);
        $this->assertArrayHasKey('avgFulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxFulfilledTime', $result[0]);
        $this->assertArrayHasKey('minFulfilledTime', $result[0]);
        $this->assertArrayHasKey('unfulfilled', $result[0]);
        $this->assertArrayHasKey('avgUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('minUnfulfilledTime', $result[0]);

        $result = $ladesk->getChatsSLALogReport('2016-01-01', '2015-01-15');
        /* empty for now
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('conversationid', $result);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('departmentid', $result);
        $this->assertArrayHasKey('department_name', $result);
        $this->assertArrayHasKey('levelid', $result);
        $this->assertArrayHasKey('sla_level_name', $result);
        $this->assertArrayHasKey('sla', $result);
        $this->assertArrayHasKey('date_created', $result);
        $this->assertArrayHasKey('date_closed', $result);
        $this->assertArrayHasKey('server_date_closed', $result);
        $this->assertArrayHasKey('date_due', $result);
        $this->assertArrayHasKey('server_date_due', $result);
        $this->assertArrayHasKey('sla_level_id', $result);
        $this->assertArrayHasKey('agentid', $result);
        $this->assertArrayHasKey('agent_firstname', $result);
        $this->assertArrayHasKey('agent_lastname', $result);
        $this->assertArrayHasKey('req_contactid', $result);
        $this->assertArrayHasKey('req_firstname', $result);
        $this->assertArrayHasKey('req_lastname', $result);
         */

        $params = array(
            'columns' => '',
            'limicount' => '',
            'limitfrom' => ''
        );
        $result = $ladesk->getTagsReport('2016-01-01', '2015-01-15');
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('tagName', $result[0]);
        $this->assertArrayHasKey('answers', $result[0]);
        $this->assertArrayHasKey('chat_answers', $result[0]);
        $this->assertArrayHasKey('chats', $result[0]);
        $this->assertArrayHasKey('calls', $result[0]);
        $this->assertArrayHasKey('rewards', $result[0]);
        $this->assertArrayHasKey('punishments', $result[0]);

        $result = $ladesk->getDepartmentsReport('2016-01-01', '2015-01-15');
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('departmentName', $result[0]);
        $this->assertArrayHasKey('answers', $result[0]);
        $this->assertArrayHasKey('chat_answers', $result[0]);
        $this->assertArrayHasKey('chats', $result[0]);
        $this->assertArrayHasKey('calls', $result[0]);
        $this->assertArrayHasKey('rewards', $result[0]);
        $this->assertArrayHasKey('punishments', $result[0]);

        $result = $ladesk->getChannelsReport('2016-01-01', '2015-01-15');
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('channelName', $result[0]);
        $this->assertArrayHasKey('answers', $result[0]);
        $this->assertArrayHasKey('chat_answers', $result[0]);
        $this->assertArrayHasKey('chats', $result[0]);
        $this->assertArrayHasKey('calls', $result[0]);
        $this->assertArrayHasKey('rewards', $result[0]);
        $this->assertArrayHasKey('punishments', $result[0]);

        $result = $ladesk->getAgentsReport('2016-01-01', '2015-01-15');
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('contactid', $result[0]);
        $this->assertArrayHasKey('firstname', $result[0]);
        $this->assertArrayHasKey('lastname', $result[0]);
        $this->assertArrayHasKey('answers', $result[0]);
        $this->assertArrayHasKey('chat_answers', $result[0]);
        $this->assertArrayHasKey('chats', $result[0]);
        $this->assertArrayHasKey('calls', $result[0]);
        $this->assertArrayHasKey('rewards', $result[0]);
        $this->assertArrayHasKey('punishments', $result[0]);

        $params = array(
            'date_from' => '',
            'date_to' => '',
            'columns' => '',
            'limicount' => '',
            'limitfrom' => '',
            'departmentid' => '',
            'agentid' => ''
        );
        $result = $ladesk->getTicketsAgentAvailabilityReport();
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

        $result = $ladesk->getCallsAgentAvailabilityReport();
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

        $result = $ladesk->getTicketsLoadReport();
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

        $result = $ladesk->getCallsLoadReport();
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

        $result = $ladesk->getTicketsSLAComplianceReport();
        $this->assertArrayHasKey('date', $result[0]);
        $this->assertArrayHasKey('fulfilled', $result[0]);
        $this->assertArrayHasKey('avgFulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxFulfilledTime', $result[0]);
        $this->assertArrayHasKey('minFulfilledTime', $result[0]);
        $this->assertArrayHasKey('unfulfilled', $result[0]);
        $this->assertArrayHasKey('avgUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('minUnfulfilledTime', $result[0]);

        $result = $ladesk->getCallsSLAComplianceReport();
        $this->assertArrayHasKey('date', $result[0]);
        $this->assertArrayHasKey('fulfilled', $result[0]);
        $this->assertArrayHasKey('avgFulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxFulfilledTime', $result[0]);
        $this->assertArrayHasKey('minFulfilledTime', $result[0]);
        $this->assertArrayHasKey('unfulfilled', $result[0]);
        $this->assertArrayHasKey('avgUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('maxUnfulfilledTime', $result[0]);
        $this->assertArrayHasKey('minUnfulfilledTime', $result[0]);

        $result = $ladesk->getTicketsSLALogReport('2016-01-01', '2015-01-15');
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('conversationid', $result[0]);
        $this->assertArrayHasKey('departmentid', $result[0]);
        $this->assertArrayHasKey('levelid', $result[0]);
        $this->assertArrayHasKey('sla', $result[0]);
        $this->assertArrayHasKey('date_created', $result[0]);
        $this->assertArrayHasKey('date_closed', $result[0]);
        $this->assertArrayHasKey('server_date_closed', $result[0]);
        $this->assertArrayHasKey('date_due', $result[0]);
        $this->assertArrayHasKey('server_date_due', $result[0]);
        $this->assertArrayHasKey('sla_level_id', $result[0]);
        $this->assertArrayHasKey('agentid', $result[0]);
        $this->assertArrayHasKey('req_contactid', $result[0]);

        $result = $ladesk->getCallsSLALogReport('2016-01-01', '2015-01-15');
        /* empty for now
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('conversationid', $result[0]);
        $this->assertArrayHasKey('departmentid', $result[0]);
        $this->assertArrayHasKey('levelid', $result[0]);
        $this->assertArrayHasKey('sla', $result[0]);
        $this->assertArrayHasKey('date_created', $result[0]);
        $this->assertArrayHasKey('date_closed', $result[0]);
        $this->assertArrayHasKey('server_date_closed', $result[0]);
        $this->assertArrayHasKey('date_due', $result[0]);
        $this->assertArrayHasKey('server_date_due', $result[0]);
        $this->assertArrayHasKey('sla_level_id', $result[0]);
        $this->assertArrayHasKey('agentid', $result[0]);
        $this->assertArrayHasKey('req_contactid', $result[0]);*/

        $params = array(
            'columns' => '',
            'limicount' => '',
            'limitfrom' => '',
            'agentid' => '',
            'contactid' => '',
            'types' => ''
        );
        $result = $ladesk->getRankingAgentsReport('2016-01-01', '2015-01-15');
        /* empty for now
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('rankingType', $result[0]);
        $this->assertArrayHasKey('datecreated', $result[0]);
        $this->assertArrayHasKey('conversationid', $result[0]);
        $this->assertArrayHasKey('agentcontactid', $result[0]);
        $this->assertArrayHasKey('agentEmail', $result[0]);
        $this->assertArrayHasKey('agent', $result[0]);
        $this->assertArrayHasKey('contactid', $result[0]);
        $this->assertArrayHasKey('requesterEmail', $result[0]);
        $this->assertArrayHasKey('server_date_due', $result[0]);
        $this->assertArrayHasKey('requester', $result[0]);
        $this->assertArrayHasKey('comment', $result[0]);*/
    }

    public function testKnowledgebase()
    {
        $ladesk = $this->getApi();

        $params = array(
            'content' => 'Article content',
            'title' => 'Article title',
            //'kb_id' => '',
            //'parent_entry_id' => '',
            //'rstatus' => '',
            //'access' => '',
            //'rorder' => '',
            //'keywords' => '',
            //'full_preview' => ''
        );
//        $result = $ladesk->addArticleToKnowledgebase($params);
//        $this->assertArrayHasKey('kb_id', $result);
//        $this->assertArrayHasKey('kb_entry_id', $result);
//        $this->assertArrayHasKey('parent_entry_id', $result);
//        $this->assertArrayHasKey('urlcode', $result);
//        $this->assertArrayHasKey('title', $result);
//        $this->assertArrayHasKey('content', $result);
//        $this->assertArrayHasKey('content_text', $result);
//        $this->assertArrayHasKey('content_simple_html', $result);
//        $this->assertArrayHasKey('treepath', $result);
//        $this->assertArrayHasKey('rstatus', $result);
//        $this->assertArrayHasKey('access', $result);
//        $this->assertArrayHasKey('access_inherited', $result);
//        $this->assertArrayHasKey('rorder', $result);
//        $this->assertArrayHasKey('keywords', $result);
//        $this->assertArrayHasKey('datecreated', $result);
//        $this->assertArrayHasKey('datechanged', $result);
//        $this->assertArrayHasKey('views', $result);

        $result = $ladesk->getKnowledgebaseArticles();
        $this->assertArrayHasKey('kb_id', $result[0]);
        $this->assertArrayHasKey('kb_entry_id', $result[0]);
        $this->assertArrayHasKey('parent_entry_id', $result[0]);
        $this->assertArrayHasKey('rtype', $result[0]);
        $this->assertArrayHasKey('rstatus', $result[0]);
        $this->assertArrayHasKey('access', $result[0]);
        $this->assertArrayHasKey('access_inherited', $result[0]);
        $this->assertArrayHasKey('urlcode', $result[0]);
        $this->assertArrayHasKey('treepath', $result[0]);
        $this->assertArrayHasKey('rorder', $result[0]);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('metadescription', $result[0]);
        $this->assertArrayHasKey('keywords', $result[0]);
        $this->assertArrayHasKey('content', $result[0]);
        $this->assertArrayHasKey('conversationid', $result[0]);
        $this->assertArrayHasKey('departmentid', $result[0]);
        $this->assertArrayHasKey('views', $result[0]);
        $this->assertArrayHasKey('votes', $result[0]);
        $this->assertArrayHasKey('datecreated', $result[0]);
        $this->assertArrayHasKey('datechanged', $result[0]);
        $this->assertArrayHasKey('deleted', $result[0]);
        $this->assertArrayHasKey('description', $result[0]);

        $result = $ladesk->getKnowledgebases();
        $this->assertArrayHasKey('kb_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);

        $result = $ladesk->searchKnowledgebase('title');
        $this->assertArrayHasKey('kb_id', $result[0]);
        $this->assertArrayHasKey('kb_entry_id', $result[0]);
        $this->assertArrayHasKey('rtype', $result[0]);
        $this->assertArrayHasKey('rstatus', $result[0]);
        $this->assertArrayHasKey('access', $result[0]);
        $this->assertArrayHasKey('access_inherited', $result[0]);
        $this->assertArrayHasKey('urlcode', $result[0]);
        $this->assertArrayHasKey('treepath', $result[0]);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('title_clear', $result[0]);
        $this->assertArrayHasKey('content_text', $result[0]);
        $this->assertArrayHasKey('content_simple_html', $result[0]);
        $this->assertArrayHasKey('conversationid', $result[0]);
        $this->assertArrayHasKey('votesCount', $result[0]);
        $this->assertArrayHasKey('datechanged', $result[0]);
        $this->assertArrayHasKey('url', $result[0]);

        $id = $result[0]['kb_entry_id'];
        $data = array(
            'keywords' => 'keyword'
        );
//        $result = $ladesk->changeKnowledgebaseArticle($id, $data);

        $data = array(
            'title' => 'Category title'
        );
//        $result = $ladesk->addKnowledgebaseCategory($data);
//        $this->assertArrayHasKey('kb_id', $result);
//        $this->assertArrayHasKey('kb_entry_id', $result);
//        $this->assertArrayHasKey('parent_entry_id', $result);
//        $this->assertArrayHasKey('urlcode', $result);
//        $this->assertArrayHasKey('title', $result);
//        $this->assertArrayHasKey('treepath', $result);
//        $this->assertArrayHasKey('rtype', $result);
//        $this->assertArrayHasKey('rstatus', $result);
//        $this->assertArrayHasKey('access', $result);
//        $this->assertArrayHasKey('access_inherited', $result);
//        $this->assertArrayHasKey('rorder', $result);
//        $this->assertArrayHasKey('keywords', $result);
//        $this->assertArrayHasKey('datecreated', $result);
//        $this->assertArrayHasKey('datechanged', $result);
//        $this->assertArrayHasKey('departmentid', $result);
//        $this->assertArrayHasKey('views', $result);
//        $this->assertArrayHasKey('description', $result);

        $data = array(
            'title' => 'new title'
        );
//        $result = $ladesk->changeKnowledgebaseCategory($id, $data);

//        $result = $ladesk->deleteKnowledgebaseArticle($id);

    }

    public function testWidgets()
    {
        $ladesk = $this->getApi();
        $result = $ladesk->getWidgets();

        $id = $result[0]['contactwidgetid'];
        $result = $ladesk->getWidget($id);

        $onlineDepartmens = $ladesk->getDepartmentOnlineStatus();
        $departmentId = $onlineDepartmens[0]['id'];
        $data = array(
            'name' => 'widget name',
            'provide' => 't',
            'departmentid' => $departmentId,
            'rtype' => 'C',
            'usecode' => 'F',
            'status' => 'F',
            'attributes' => ''/* ATTRIBUTES */,
            'language' => 'en'
        );
        $result = $ladesk->addWidget($data);

        $data = array(
            'name' => 'Hosting24_Publicx',
            'provide' => 'BFC',
            'departmentid' => 'default',
            'rtype' => 'C',
            'usecode' => 'B',
            'status' => 'N',
            'attributes' => array(
                // ATTRIBUTES HERE
            )
        );
//        $result = $ladesk->changeWidget('0670d2b9', $data);

//        $result = $ladesk->deleteWidget('0670d2b9xx');
    }

    public function testFiles()
    {
        $ladesk = $this->getApi();

        $data = array(
            'name' => 'myFileName',
            'type' => 'image/png',
            'downloadUrl' => 'http://a5.mzstatic.com/us/r30/Purple5/v4/5a/2e/e9/5a2ee9b3-8f0e-4f8b-4043-dd3e3ea29766/icon128-2x.png'
        );
//        $result = $ladesk->addFile($data);
//        $this->assertArrayHasKey('fileid', $result);
//        $this->assertArrayHasKey('created', $result);
//        $this->assertArrayHasKey('filename', $result);
//        $this->assertArrayHasKey('filesize', $result);
//        $this->assertArrayHasKey('filetype', $result);
//        $this->assertArrayHasKey('downloads', $result);
//        $this->assertArrayHasKey('downloadUrl', $result);

//        $result = $ladesk->getFile('616ef0d9458f52f5d617c38a7b200313');
//        $this->assertArrayHasKey('fileid', $result);
//        $this->assertArrayHasKey('created', $result);
//        $this->assertArrayHasKey('filename', $result);
//        $this->assertArrayHasKey('filesize', $result);
//        $this->assertArrayHasKey('filetype', $result);
//        $this->assertArrayHasKey('downloads', $result);
//        $this->assertArrayHasKey('downloadUrl', $result);

//        $result = $ladesk->deleteFile('616ef0d9458f52f5d617c38a7b200313');
    }

}
