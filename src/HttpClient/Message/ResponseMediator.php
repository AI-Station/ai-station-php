<?php

declare(strict_types=1);

namespace AIStation\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

final class ResponseMediator
{
    public static function getContent(ResponseInterface $response): array
    {
        try {
            $responseJson = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new InvalidResponseException('Could not parse the response from the station api. Please check the station api logs');
        }
        if($response->getStatusCode() !== 200) {
            $message = 'Got an invalid response from the station api. Please check the station api logs';
            if(isset($responseJson['message'])) {
                $message = $responseJson['message'];
            }
            throw new InvalidResponseException($message);
        }
        return $responseJson;
    }
}
