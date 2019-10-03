<?php


namespace core;

/**
 * Class Curl
 * @package core
 */
class Curl implements HttpClient
{
    private $ch;

    public function __construct()
    {
        $this->ch = curl_init();
        $this->configCurl();
    }

    /**
     * Save user credentials
     * @param string $user
     * @param string $password
     * @return mixed
     */
    public function auth(string $user, string $password): void
    {
        curl_setopt($this->ch, CURLOPT_USERPWD, $user . ':' . $password);
    }

    /**
     * Make new request
     * @param string $type
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function request(string $type, string $url, array $data = []): HttpResponse
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);

        if ($type == 'POST') {
            curl_setopt($this->ch, CURLOPT_POST, 1);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data['data']);
        }

        if (isset($data['headers'])) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $data['headers']);
        }

        if (in_array($type, ['DELETE', 'PUT', 'PATCH'])) {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $type);
        }

        $result = curl_exec($this->ch);

        return $this->createResponse($result);
    }

    /**
     * GET request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function get(string $url, array $data = []): HttpResponse
    {
        return $this->request('GET', $url, $data);
    }

    /**
     * POST request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function post(string $url, array $data = []): HttpResponse
    {
        return $this->request('POST', $url, $data);
    }

    /**
     * DELETE request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function delete(string $url, array $data = []): HttpResponse
    {
        return $this->request('DELETE', $url, $data);
    }

    /**
     * Close curl connection
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }

    /**
     * Config curl transport
     */
    private function configCurl(): void
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // @todo remove
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
    }

    /**
     * Parse response and create response
     * @param $result
     * @return HttpResponse
     */
    private function createResponse($result): HttpResponse
    {
        if (!curl_errno($this->ch)) {
            $http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);
            if ($contentType) {
                $parse = explode(';', $contentType);
                if ($parse[0] === 'application/json') {
                    $result = json_decode($result, TRUE);
                }
            }

            return new HttpResponse($http_code, $result);
        } else {
            return new HttpResponse(HttpResponse::STATUS_ERROR, curl_error($this->ch));
        }
    }
}
