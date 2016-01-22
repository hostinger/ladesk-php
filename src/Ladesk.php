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

    public function getConversations()
    {
        $result = $this->call('GET', 'conversations');
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

    public function getAgent($id)
    {
        return $this->call('GET', 'agents/' . $id);
    }

    public function getAgentOnlineStatus()
    {
        $result = $this->call('GET', 'onlinestatus/agents');
        return $result['agentsOnlineStates'];
    }

    public function getCustomers($param = array())
    {
        return $this->call('GET', 'customers/', $param);
    }

    public function getCustomer($id)
    {
        return $this->call('GET', 'customers/' . $id);
    }

    public function createConversation($data = array())
    {
        $params = array(
            'useridentifier' => 'andrius@hostinger.com',
            'recipient' => 'andrius.putna@gmail.com',
            'department' => '8c2ad2e8',
            'subject' => 'Testing message via API',
            'message' => 'This message was created via REST API',
        );
        $result = $this->call('POST', 'conversations', $params);
        $id = $result['conversationid'];

        if($data['tag']) {
            $this->assignTagForConversation($id, $data['tag']);
        }
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

    public function addMessageToConversation($conversationId, $message, $user_identifier)
    {
        $params = array(
            'useridentifier' => $user_identifier,
            'message' => $message,
            'type' => 'M',
        );

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

    public function assignTagForConversation($conversationId, $tag)
    {
        $params = array(
            'name' => $tag,
        );
        $result = $this->call('POST', 'conversations/'.$conversationId.'/tags', $params);
        return $result;
    }

    public function unassignTagForConversation($conversationId, $name)
    {
        $params = array(
            'name' => $name,
        );
        $result = $this->call('DELETE', 'conversations/'.$conversationId.'/tags', $params);
        return $result;
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