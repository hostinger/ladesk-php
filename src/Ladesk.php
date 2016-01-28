<?php

namespace Ladesk;

use GuzzleHttp\Client;

class Ladesk
{

    public function __construct($url, $key)
    {
        $this->api_key = $key;
        $this->client = new Client(array(
            'base_uri' => $url . '/api/index.php',
            'timeout' => 5,
        ));
    }

    public function getApplicationStatus()
    {
        return $this->call('GET', 'application/status');
    }

    public function getChatsOverview()
    {
        $result = $this->call('GET', 'chats/overview');
        return $result['chatsOverview'];
    }

    public function getCallsOverview()
    {
        $result = $this->call('GET', 'calls/overview');
        return $result['callsOverview'];
    }

    public function getCompanies()
    {
        $result = $this->call('GET', 'companies');
        return $result['companies'];
    }

    public function getCompany($id)
    {
        $result = $this->call('GET', 'companies/'.$id);
        return $result;
    }

    public function getTags()
    {
        $result = $this->call('GET', 'tags');
        return $result['tags'];
    }

    public function getConversations($params = array())
    {
        $result = $this->call('GET', 'conversations', $params);
        return $result['conversations'];
    }

    public function getConversation($id)
    {
        $result = $this->call('GET', 'conversations/' . $id);
        return $result;
    }

    public function getConversationMessages($id)
    {
        $result = $this->call('GET', 'conversations/' . $id . '/messages');
        return $result;
    }

    public function getConversationTags($id)
    {
        $result = $this->call('GET', 'conversations/' . $id . '/tags');
        return $result;
    }

    public function getDepartments()
    {
        $result = $this->call('GET', 'departments');
        return $result['departments'];
    }

    public function getDepartment($id)
    {
        $result = $this->call('GET', 'departments/' . $id);
        return $result;
    }

    public function getAgent($id)
    {
        return $this->call('GET', 'agents/' . $id);
    }

    public function getAgentsFromDepartment($id)
    {
        $result = $this->call('GET', 'departments/' . $id . '/agents');
        return $result;
    }

    public function getAgentOnlineStatus()
    {
        $result = $this->call('GET', 'onlinestatus/agents');
        return $result['agentsOnlineStates'];
    }

    public function getDepartmentOnlineStatus()
    {
        $result = $this->call('GET', 'onlinestatus/departments');
        return $result['departmentsOnlineStates'];
    }

    public function getCustomers($param = array())
    {
        $result = $this->call('GET', 'customers/', $param);
        return $result['customers'];
    }

    public function getCustomer($id)
    {
        return $this->call('GET', 'customers/' . $id);
    }

    public function getTag($id)
    {
        return $this->call('GET', 'tags/' . $id);
    }

    public function getCustomersGroups()
    {
        $result = $this->call('GET', 'customersgroups/');
        return $result['groups'];
    }

    public function getCustomersGroup($id)
    {
        return $this->call('GET', 'customersgroups/' . $id);
    }

    public function getCustomerGroups($id)
    {
        $result = $this->call('GET', 'customers/' . $id . '/groups');
        return $result['groups'];
    }

    public function getSuggestionCategories()
    {
        $result = $this->call('GET', 'suggestioncategories/');
        return $result['suggestioncategories'];
    }

    public function getCallsAgentAvailabilityReport($params = array())
    {
        $result = $this->call('GET', 'reports/calls/agentsavailability', $params);
        return $result['agentsavailability'];
    }

    public function getTicketsAgentAvailabilityReport($params = array())
    {
        $result = $this->call('GET', 'reports/tickets/agentsavailability', $params);
        return $result['agentsavailability'];
    }

    public function getChatAgentAvailabilityReport($params = array())
    {
        $result = $this->call('GET', 'reports/chats/agentsavailability', $params);
        return $result['agentsavailability'];
    }

    public function getCallsAvailabilityReport($params = array())
    {
        $result = $this->call('GET', 'reports/chats/availability', $params);
        return $result['availability'];
    }

    public function getChatsAvailabilityReport($params = array())
    {
        $result = $this->call('GET', 'reports/chats/availability', $params);
        return $result['availability'];
    }

    public function getCallsLoadReport($params = array())
    {
        $result = $this->call('GET', 'reports/calls/load', $params);
        return $result['loads'];
    }

    public function getTicketsLoadReport($params = array())
    {
        $result = $this->call('GET', 'reports/tickets/load', $params);
        return $result['loads'];
    }

    public function getChatsLoadReport($params = array())
    {
        $result = $this->call('GET', 'reports/chats/load', $params);
        return $result['loads'];
    }

    public function getCallsSLAComplianceReport($params = array())
    {
        $result = $this->call('GET', 'reports/calls/slacompliance', $params);
        return $result['slacompliances'];
    }

    public function getTicketsSLAComplianceReport($params = array())
    {
        $result = $this->call('GET', 'reports/tickets/slacompliance', $params);
        return $result['slacompliances'];
    }

    public function getChatsSLAComplianceReport($params = array())
    {
        $result = $this->call('GET', 'reports/chats/slacompliance', $params);
        return $result['slacompliances'];
    }

    public function getCallsSLALogReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/calls/slalog', $params);
        return $result['slalogs'];
    }

    public function getTicketsSLALogReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/tickets/slalog', $params);
        return $result['slalogs'];
    }

    public function getChatsSLALogReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/chats/slalog', $params);
        return $result['slalogs'];
    }

    public function getRankingAgentsReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/ranking', $params);
        return $result['ranks'];
    }

    public function getTagsReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/tags', $params);
        return $result['tags'];
    }

    public function getDepartmentsReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/departments', $params);
        return $result['departments'];
    }

    public function getChannelsReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/channels', $params);
        return $result['channels'];
    }

    public function getAgentsReport($date_from, $date_to, $otherparams = array())
    {
        $params = array(
            'date_from' => $date_from,
            'date_to' => $date_to
        );
        $params = array_merge($params, $otherparams);
        $result = $this->call('GET', 'reports/agents', $params);
        return $result['agents'];
    }

    public function getKnowledgebases()
    {
        $result = $this->call('GET', 'knowledgebase/knowledgebases');
        return $result['knowledgebases'];
    }

    public function getKnowledgebaseArticles()
    {
        $result = $this->call('GET', 'knowledgebase/entries');
        return $result['entries'];
    }

    public function getWidgets()
    {
        $result = $this->call('GET', 'widgets');
        return $result['widgets'];
    }

    public function getWidget($id)
    {
        $result = $this->call('GET', 'widgets/' . $id);
        return $result;
    }

    public function getFile($id)
    {
        $result = $this->call('GET', 'files/' . $id);
        return $result;
    }

    public function createConversation($data = array())
    {
        $result = $this->call('POST', 'conversations', $data);
        $id = $result['conversationid'];
        if($data['tag']) {
            $this->assignTagForConversation($id, $data['tag']);
        }
        return $result;
    }

    public function setConversationResolved($conversationId)
    {
        $params = array(
            'status' => 'R',
        );
        return $this->call('PUT', 'conversations/'.$conversationId.'/status', $params);
    }

    public function setConversationOpen($conversationId)
    {
        $params = array(
            'status' => 'C',
        );
        return $this->call('PUT', 'conversations/'.$conversationId.'/status', $params);
    }

    public function setConversationAnswered($conversationId)
    {
        $params = array(
            'status' => 'A',
        );
        return $this->call('PUT', 'conversations/'.$conversationId.'/status', $params);
    }

    public function transferConversation($id, $data = array())
    {
        $result = $this->call('PUT', 'conversations/' . $id . '/attendants', $data);
        return $result;
    }

    public function deleteConversation($id, $data = array())
    {
        $result = $this->call('DELETE', 'conversations/' . $id, $data);
        return $result;
    }

    public function deleteFile($id)
    {
        $result = $this->call('DELETE', 'files/' . $id);
        return $result;
    }

    public function deleteCustomerFromGroup($id, $name)
    {
        $param = array(
            'name' => $name
        );
        $result = $this->call('DELETE', 'customers/' . $id . '/groups', $param);
        return $result;
    }

    public function addMessageToConversation($conversationId, $message, $user_identifier, $otherparams = array())
    {
        $params = array(
            'useridentifier' => $user_identifier,
            'message' => $message,
            'type' => 'M',
        );

        $params = array_merge($params, $otherparams);

        return $this->call('POST', 'conversations/'.$conversationId.'/messages', $params);
    }

    public function addNoteToConversation($conversationId, $message)
    {
        $params = array(
            'message' => $message,
            'type' => 'N',
        );
        return $this->call('POST', 'conversations/'.$conversationId.'/messages', $params);
    }

    public function addCustomFieldToConversation($conversationId, $params)
    {
        return $this->call('POST', 'conversations/'.$conversationId.'/fields', $params);
    }

    public function addCustomFieldToCustomer($conversationId, $params)
    {
        return $this->call('POST', 'customers/'.$conversationId.'/fields', $params);
    }

    public function addCustomerToGroup($id, $groupName)
    {
        $params = array(
            'name' => $groupName,
        );
        return $this->call('POST', 'customers/'.$id.'/groups', $params);
    }

    public function addCustomersGroup($params)
    {
        return $this->call('POST', 'customersgroups/', $params);
    }

    public function addTag($params)
    {
        return $this->call('POST', 'tags/', $params);
    }

    public function addWidget($params)
    {
        return $this->call('POST', 'widgets/', $params);
    }

    public function changeTag($id, $params)
    {
        return $this->call('PUT', 'tags/' . $id, $params);
    }

    public function assignTagForConversation($conversationId, $tag)
    {
        $params = array(
            'name' => $tag,
        );
        $result = $this->call('POST', 'conversations/'.$conversationId.'/tags', $params);
        return $result;
    }

    public function unassignTagFromConversation($conversationId, $name)
    {
        $params = array(
            'name' => $name,
        );
        $result = $this->call('DELETE', 'conversations/'.$conversationId.'/tags', $params);
        return $result;
    }

    public function addArticleToKnowledgebase($params)
    {
        return $this->call('POST', 'knowledgebase/articles', $params);
    }

    public function addKnowledgebaseCategory($params)
    {
        return $this->call('POST', 'knowledgebase/categories', $params);
    }

    public function addFile($params)
    {
        return $this->call('POST', 'files', $params);
    }

    public function registerCustomer($data)
    {
        return $this->call('POST', 'customers/', $data);
    }

    public function deleteCustomersGroup($id)
    {
        return $this->call('DELETE', 'customersgroups/' . $id);
    }

    public function deleteTag($id)
    {
        return $this->call('DELETE', 'tags/' . $id);
    }

    public function deleteWidget($id)
    {
        return $this->call('DELETE', 'widgets/' . $id);
    }

    public function deleteKnowledgebaseArticle($id)
    {
        return $this->call('DELETE', 'knowledgebase/entries/' . $id);
    }

    public function deleteCustomFieldFromConversation($id, $param = array())
    {
        return $this->call('DELETE', 'conversations/' . $id . '/fields', $param);
    }

    public function deleteCustomFieldFromCustomer($id, $param = array())
    {
        return $this->call('DELETE', 'customers/' . $id . '/fields', $param);
    }

    public function changeCustomersGroup($id, $params)
    {
        $result = $this->call('PUT', 'customersgroups/' . $id, $params);
        return $result;
    }

    public function changeKnowledgebaseArticle($id, $params)
    {
        $result = $this->call('PUT', 'knowledgebase/articles/' . $id, $params);
        return $result;
    }

    public function changeKnowledgebaseCategory($id, $params)
    {
        $result = $this->call('PUT', 'knowledgebase/categories/' . $id, $params);
        return $result;
    }

    public function changeWidget($id, $params)
    {
        $result = $this->call('PUT', 'widgets/' . $id, $params);
        return $result;
    }

    public function searchKnowledgebase($term)
    {
        $param = array(
            'query' => $term
        );
        $result = $this->call('GET', 'knowledgebase/search', $param);
        return $result['entries'];
    }
    
    private function call($method, $url, array $params = array())
    {
        $query = array_merge(array(
            'handler' => $url,
            'apikey' => $this->api_key,
        ), $params);

        $options = array(
            'query' => $query,
        );

        $response = $this->client->request($method, '', $options);
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
