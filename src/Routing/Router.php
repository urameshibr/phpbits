<?php

namespace Root\Routing;

use Root\Server;

class Router
{
    const CONTENT_TYPE_JSON = 'json';
    const CONTENT_TYPE_TEXT_HTML = 'text_html';

    private $headerContentType;
    private $response;
    private $routes;

    public function handle(string $redirect_url, array $server_attributes = [])
    {
        print_r($server_attributes);

        $redirect_url = empty($redirect_url) ? '/' : $redirect_url;

        if ($redirect_url !== '/' && file_exists(__DIR__ . '/../../public' . $redirect_url)) return false;

        foreach ($this->routes as $route) {
            if ($route['url'] === $redirect_url) return $this->runAction($route['action']);
        }

        header("HTTP/1.1 404");
        exit();
    }

    public function runAction($action)
    {
        if (is_string($action)) return $this->runControllerAction($action);

        return $this->runClosure($action);
    }

    private function runControllerAction(string $action)
    {
        $arr = explode('@', $action);
        $controllerClass = $arr[0];
        $action = $arr[1];
        $this->response = (new $controllerClass)->$action();
        $this->configureHeaders($this->response);

        return $this->response;
    }

    public function configureHeaders($response)
    {
        $this->headerContentType = 'text_html';

        if (is_array($response)) {
            $this->headerContentType = 'json';
            $this->setHeaderContentType($this->headerContentType);
            $this->response = json_encode($response);
        }

        if ($response === 0) {
            $this->response = (string)$response;
        }

        if (is_bool($response) && !$response) {
            $this->response = (string)0;
        }

        if (is_object($response)) {
            $this->headerContentType = 'json';
            $this->setHeaderContentType($this->headerContentType);
            $this->response = json_encode($response);
        }

        return $this;
    }

    public function addRoute(string $verb, $url, $action)
    {
        $this->routes[] = [
            'verb' => $verb,
            'url' => $url,
            'action' => $action,
        ];
    }

    public function get(string $url, $action)
    {
        $this->addRoute('GET', empty($url) ? '/' : $url, $action);

        return $this;
    }

    public function setHeaderContentType(string $content_type = self::CONTENT_TYPE_TEXT_HTML)
    {
        $types = [
            'text_html' => 'Content-type: Application/text_html',
            'json' => 'Content-type: Application/json',
        ];
        $header = array_key_exists($content_type, $types)
            ? $types[$content_type]
            : $types['text_html'];

        return header($header);
    }

    private function runClosure(\Closure $closure)
    {
        $this->response = $closure();
        $this->configureHeaders($this->response);

        return $this->response;
    }
}