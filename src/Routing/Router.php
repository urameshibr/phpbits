<?php

namespace Root\Routing;

class Router
{
    const CONTENT_TYPE_JSON = 'json';
    const CONTENT_TYPE_TEXT_HTML = 'text_html';

    private $headerContentType;
    private $current_uri;
    private $response;
    private $routes;

    public function handle()
    {
        $this->current_uri = $_SERVER['REQUEST_URI'];
        if ($this->current_uri !== '/' && file_exists(__DIR__ . '/../../public' . $this->current_uri)) return false;

        foreach ($this->routes as $route) {
            if ($route['uri'] === $this->current_uri) return $this->runAction($route['action']);
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

        return $this;
    }

    public function addRoute(string $verb, $uri, $action)
    {
        $this->routes[] = [
            'verb' => $verb,
            'uri' => $uri,
            'action' => $action,
        ];
    }

    public function get(string $uri = '/', $action)
    {
        $this->addRoute('GET', $uri, $action);

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
        return $closure();
    }
}