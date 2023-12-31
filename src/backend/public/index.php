<?php

require __DIR__.'/../vendor/autoload.php';

$router = new \Buki\Router\Router();

$router->post("encode", function(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Response $response) {
    try {
        $validator = new \Rakit\Validation\Validator();
        $validation = $validator->make([
            'url' => $_POST['url'],
        ], [
            'url' => 'required|url:http',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $response->setStatusCode(403);
            $response->setContent(json_encode(['error' => 'Ссылка имеет неправильный формат'], JSON_UNESCAPED_SLASHES));
            return $response;
        }
        $url = $_POST['url'];
        $urls = new \Flintstone\Flintstone('urls', ["dir" => '/var/cache/profiru']);
        $lastIdentifiers = new \Flintstone\Flintstone('identifiers', ["dir" => '/var/cache/profiru']);
        if (!$lastIdentifiers->get('lastIdentifier')) {
            $lastIdentifiers->set('lastIdentifier', 1);
        } else {
            $lastIdentifiers->set('lastIdentifier', $lastIdentifiers->get('lastIdentifier') + 1);
        }
        $sqids = new \Sqids\Sqids();
        $hash = $sqids->encode([$lastIdentifiers->get('lastIdentifier')]);
        $urls->set($hash, $url);
        $response->setContent(json_encode(["url" => "http://localhost:8081/$hash"], JSON_UNESCAPED_SLASHES));
        return $response;
    } catch (Exception $exception) {
        $response->setStatusCode(500);
        return $response;
    }
});

$router->get(":any", function ($hash, \Symfony\Component\HttpFoundation\Response $response) {
    try {
        $urls = new \Flintstone\Flintstone('urls', ["dir" => '/var/cache/profiru']);
        $url = $urls->get($hash);
        header("Location: $url");
        exit();
    } catch (Exception $exception) {
        $response->setStatusCode(500);
        return $response;
    }
});

$router->run();
