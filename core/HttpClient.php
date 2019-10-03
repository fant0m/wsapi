<?php


namespace core;

/**
 * Interface HttpClient
 * @package core
 */
interface HttpClient
{
    /**
     * Save user credentials
     * @param string $user
     * @param string $password
     * @return mixed
     */
    public function auth(string $user, string $password);

    /**
     * Make new request
     * @param string $type
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function request(string $type, string $url, array $data = []) : HttpResponse;

    /**
     * GET request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function get(string $url, array $data = []) : HttpResponse;

    /**
     * POST request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function post(string $url, array $data = []) : HttpResponse;

    /**
     * DELETE request
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function delete(string $url, array $data = []) : HttpResponse;

    // @todo add methods for put, patch and other useful stuff..
}
