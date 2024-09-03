<?php

namespace Tests\Paynl;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Imbue\Paynl\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;
use Imbue\Paynl\PaynlClient;

class ApiClientTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;
    /** @var PaynlClient */
    private $paynlClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->paynlClient = new PaynlClient($this->guzzleClient);
        $this->paynlClient->setAuth('AT-1234-5678', 'test_api_token');
    }

    public function testPerformHttpCallReturnsBodyAsObject()
    {
        $response = new Response(200, [], '{
    "code": "AT-1234-5678",
    "secret": "BjYfbkywcdcf0a082acXl7mYkWvjkak3lyEJpzeD",
    "testMode": true,
    "name": "Test Merchant",
    "translations": {
        "name": {
            "nl_NL": "paynl-test-merchant.nl"
        }
    },
    "status": "ACTIVE"}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $parsedResponse = $this->paynlClient->performHttpCall('GET', 'services/config?serviceId=SL-1234-5678');

        $this->assertEquals(
            (object)[
                "code" => "AT-1234-5678",
                "secret" => "BjYfbkywcdcf0a082acXl7mYkWvjkak3lyEJpzeD",
                "testMode" => true,
                "name" => "Test Merchant",
                "translations" => (object)[
                    "name" => (object)[
                        "nl_NL" => "paynl-test-merchant.nl"
                    ]
                ],
                "status" => "ACTIVE"
            ],
            $parsedResponse
        );
    }

    public function testThrowExceptionWhenAuthIsInvalid()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You have not set an AT code.');

        $this->paynlClient->setAuth('', '');
        $this->paynlClient->performHttpCall('GET', 'services/config');

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You have not set an Api token.');
        $this->paynlClient->setAuth('AT-1234-5678', '');
        $this->paynlClient->performHttpCall('GET', 'services/config');
    }

    public function testThrowExceptionWhenServiceLocationCodeIsMissingButRequired()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('You have not set a SL code.');

        $this->paynlClient->services->get();
    }

    public function testSeeResponseWith400Response()
    {
        $response = new Response(400, [], '{
    "type": "https://developer.pay.nl/docs/error-codes",
    "title": "An error occurred",
    "detail": "code: {}",
    "violations": [
        {
            "propertyPath": "code",
            "message": "{}",
            "code": "PAY-404"
        }
    ]
}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call: An error occurred (code: {}). Error code: PAY-404');

        $this->paynlClient->performHttpCall('GET', 'services/config');
    }

    public function testSeeResponseWith401Response()
    {
        $response = new Response(401, [], '{
    "type": "https://developer.pay.nl/docs/error-codes",
    "code": "PAY-1401",
    "title": "Authentication is needed to access this resource",
    "detail": "",
    "violations": [
        {
            "propertyPath": null,
            "message": "Authentication is needed to access this resource",
            "code": "PAY-1401"
        }
    ]
}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call: Authentication is needed to access this resource (). Error code: PAY-1401');

        $this->paynlClient->performHttpCall('GET', 'services/config');
    }

    public function testSeeResponseWith403Response()
    {
        $response = new Response(403, [], '{
    "type": "https://developer.pay.nl/docs/error-codes",
    "code": "PAY-1403",
    "title": "Access denied",
    "detail": "The following permission is missing data.payment_methods",
    "violations": [
        {
            "propertyPath": null,
            "message": "Access denied",
            "code": "PAY-1403"
        }
    ]
}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call: Access denied (The following permission is missing data.payment_methods). Error code: PAY-1403');

        $this->paynlClient->performHttpCall('GET', 'services/config');
    }
}
