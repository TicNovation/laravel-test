<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class TestController extends Controller
{
    public function sendRequest(){
        
        $client = new Client(['base_uri' => 'https://atomic.incfile.com/']);

        try {

            $uri = 'fakepost';
            $response = $client->post($uri, 
            [
                'form_params'=>[
                    'test' => 'This is a test param',
                ]
            ]
            );

            echo "The request was sent successfully";

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $error['error'] = $e->getMessage();
            $error['request'] = $e->getRequest();
            $error['code'] = $e->getResponse()->getStatusCode();
            
            echo "Error message: ".$error['error'];

        } catch(\GuzzleHttp\Exception\RequestException $se){

            $error['error'] = $e->getMessage();
            $error['request'] = $e->getRequest();
            $error['code'] = $e->getResponse()->getStatusCode();

            echo "Error message: ".$error['error'];

        } catch(Exception $e){

            $error['error'] = $e->getMessage();

            echo "Error message: ".$error['error'];

        }
    }

    public function sendRequests($number_of_requests){

        $client = new Client(['base_uri' => 'https://atomic.incfile.com/']);

        $requests = function ($total) {

            $uri = 'fakepost';
            
            for ($i = 0; $i < $total; $i++) {
                yield new Request('POST', $uri, 
                [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                http_build_query( 
                [
                    'test' => 'This is a test param',
                ],null, '&')    
                );
            }
        };

        $pool = new Pool($client, $requests($number_of_requests), [
            'fulfilled' => function (Response $response, $index) {

                $number_of_response = $index + 1;
                echo "The request ".$number_of_response." was sent successfully \n";
                echo "---------------------------------------------------------------- \n";

            },
            'rejected' => function (RequestException $error, $index) {

                $number_of_response = $index + 1;
                echo "Error in request ".$number_of_response.". Message: ".$error->getMessage()."\n";
                echo "---------------------------------------------------------------- \n";

            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
                
    }
}
