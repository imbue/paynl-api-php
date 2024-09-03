<?php

namespace Tests\Paynl;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Imbue\Paynl\Resources\Service;
use PHPUnit\Framework\TestCase;
use Imbue\Paynl\PaynlClient;

class ServiceEndpointTest extends TestCase
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
        $this->paynlClient->setSlCode('SL-1234-5678');
    }

    public function testGetServiceConfig()
    {
        $response = new Response(200, [], '{
   "code":"SL-1234-5678",
   "secret":"BjYfbkywcdcf0a082acXl7mYkWvjkak3lyEJpzeD",
   "testMode":true,
   "name":"Test Merchant",
   "translations":{
      "name":{
         "nl_NL":"Test Merchant"
      }
   },
   "status":"ACTIVE",
   "merchant":{
      "code":"M-1234-5678",
      "name":"Test Merchant",
      "status":"ACTIVE"
   },
   "category":{
      "code":"CY-0000-1111",
      "name":"Other consumer Purchases"
   },
   "mcc":5678,
   "turnoverGroup":{
      "code":"CT-1234-5678",
      "name":"Test Merchant"
   },
   "layout":{
      "code":"LY-1234-8080",
      "name":"Test Merchant",
      "cssUrl":"https://static.pay.nl/layout/LY-1234-8080/cssfile.css",
      "icon":"",
      "supportingColor":"",
      "headerTextColor":"",
      "buttonColor":"000000",
      "buttonTextColor":"000000"
   },
   "tradeName":{
      "code":"TM-1234-5678",
      "name":"Test Merchant"
   },
   "createdAt":"2023-11-14T14:52:01+01:00",
   "createdBy":"A-1111-2222",
   "modifiedAt":"2024-08-16T13:21:59+02:00",
   "modifiedBy":"A-1111-2222",
   "deletedAt":null,
   "deletedBy":null,
   "checkoutOptions":[
      {
         "tag":"PG_2",
         "name":"Credit- & Debitcards",
         "translations":{
            "name":{
               "de_DE":"Kredit- und Debitkarten",
               "en_GB":"Credit- & Debitcards",
               "fr_FR":"Cartes de credit",
               "nl_NL":"Credit- & Debitcards"
            }
         },
         "image":"/payment_method_groups/CNP.svg",
         "paymentMethods":[
            {
               "id":706,
               "name":"Visa Mastercard",
               "description":"Make a secure payment by Creditcard",
               "translations":{
                  "name":{
                     "nl_NL":"Visa Mastercard"
                  },
                  "description":{
                     "en_GB":"Make a secure payment by Creditcard",
                     "nl_NL":"Betaal veilig met uw creditcard."
                  }
               },
               "image":"/payment_methods/7.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":707,
               "name":"Postepay",
               "description":"PostePay",
               "translations":{
                  "name":{
                     "nl_NL":"Postepay"
                  },
                  "description":{
                     "en_GB":"PostePay"
                  }
               },
               "image":"/payment_methods/10.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":710,
               "name":"Carte Bleue",
               "description":"Carte Bancaire",
               "translations":{
                  "name":{
                     "nl_NL":"Carte Bleue"
                  },
                  "description":{
                     "en_GB":"Carte Bancaire"
                  }
               },
               "image":"/payment_methods/11.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":712,
               "name":"Maestro",
               "description":"Maestro (Card not Present)",
               "translations":{
                  "name":{
                     "nl_NL":"Maestro"
                  },
                  "description":{
                     "en_GB":"Maestro (Card not Present)",
                     "nl_NL":"Maestro (Card not Present)"
                  }
               },
               "image":"/payment_methods/6.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":1939,
               "name":"Dankort",
               "description":"",
               "translations":{
                  "name":{
                     "nl_NL":"Dankort"
                  }
               },
               "image":"/payment_methods/58.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":1945,
               "name":"Nexi",
               "description":"Nexi",
               "translations":{
                  "name":{
                     "nl_NL":"Nexi"
                  },
                  "description":{
                     "en_GB":"Nexi"
                  }
               },
               "image":"/payment_methods/76.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":2277,
               "name":"Apple Pay",
               "description":"With Apple Pay you can safely, easily and privately make purchases in hundreds of thousands of stores, popular apps and online via Safari",
               "translations":{
                  "name":{
                     "nl_NL":"Apple Pay"
                  },
                  "description":{
                     "en_GB":"With Apple Pay you can safely, easily and privately make purchases in hundreds of thousands of stores, popular apps and online via Safari",
                     "nl_NL":"Met Apple Pay kun je veilig, eenvoudig en privacyvriendelijk aankopen doen."
                  }
               },
               "image":"/payment_methods/114.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            },
            {
               "id":2558,
               "name":"Google Wallet",
               "description":"Google Wallet",
               "translations":{
                  "name":{
                     "nl_NL":"Google Wallet"
                  },
                  "description":{
                     "en_GB":"Google Wallet",
                     "nl_NL":"Google Wallet"
                  }
               },
               "image":"/payment_methods/176.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":[
            
         ]
      },
      {
         "tag":"PM_10",
         "name":"iDEAL",
         "translations":{
            "name":{
               "nl_NL":"iDEAL"
            }
         },
         "image":"/payment_methods/1.svg",
         "paymentMethods":[
            {
               "id":10,
               "name":"iDEAL",
               "description":"Met iDEAL kunt  u met een Nederlandse bankrekening vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank.",
               "translations":{
                  "name":{
                     "nl_NL":"iDEAL"
                  },
                  "description":{
                     "en_GB":"Met iDEAL kunt u met een Nederlandse bankrekening vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank."
                  }
               },
               "image":"/payment_methods/1.svg",
               "options":[
                  {
                     "id":"1",
                     "name":"ABN Amro",
                     "image":"/issuers/1.svg"
                  },
                  {
                     "id":"2",
                     "name":"Rabobank",
                     "image":"/issuers/2.svg"
                  },
                  {
                     "id":"4",
                     "name":"ING",
                     "image":"/issuers/4.svg"
                  },
                  {
                     "id":"5",
                     "name":"SNS",
                     "image":"/issuers/5.svg"
                  },
                  {
                     "id":"8",
                     "name":"ASN Bank",
                     "image":"/issuers/8.svg"
                  },
                  {
                     "id":"9",
                     "name":"RegioBank",
                     "image":"/issuers/9.svg"
                  },
                  {
                     "id":"10",
                     "name":"Triodos Bank",
                     "image":"/issuers/10.svg"
                  },
                  {
                     "id":"11",
                     "name":"Van Lanschot",
                     "image":"/issuers/11.svg"
                  },
                  {
                     "id":"12",
                     "name":"Knab",
                     "image":"/issuers/12.svg"
                  },
                  {
                     "id":"5080",
                     "name":"Bunq",
                     "image":"/issuers/5080.svg"
                  },
                  {
                     "id":"5084",
                     "name":"Revolut",
                     "image":"/issuers/5084.svg"
                  },
                  {
                     "id":"23355",
                     "name":"N26",
                     "image":"/issuers/23355.svg"
                  },
                  {
                     "id":"23358",
                     "name":"Yoursafe",
                     "image":"/issuers/23358.svg"
                  },
                  {
                     "id":"23361",
                     "name":"Nationale-Nederlanden",
                     "image":"/issuers/23361.svg"
                  }
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_2062",
         "name":"EPS uberweisung",
         "translations":{
            "name":{
               "nl_NL":"EPS uberweisung"
            }
         },
         "image":"/payment_methods/79.svg",
         "paymentMethods":[
            {
               "id":2062,
               "name":"EPS uberweisung",
               "description":"EPS",
               "translations":{
                  "name":{
                     "nl_NL":"EPS uberweisung"
                  },
                  "description":{
                     "de_DE":"EPS uberweisung",
                     "en_GB":"EPS",
                     "nl_NL":"EPS"
                  }
               },
               "image":"/payment_methods/79.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_2151",
         "name":"Przelewy24",
         "translations":{
            "name":{
               "nl_NL":"Przelewy24"
            }
         },
         "image":"/payment_methods/93.svg",
         "paymentMethods":[
            {
               "id":2151,
               "name":"Przelewy24",
               "description":"Przelewy24",
               "translations":{
                  "name":{
                     "nl_NL":"Przelewy24"
                  },
                  "description":{
                     "en_GB":"Przelewy24"
                  }
               },
               "image":"/payment_methods/93.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_2379",
         "name":"Payconiq",
         "translations":{
            "name":{
               "nl_NL":"Payconiq"
            }
         },
         "image":"/payment_methods/138.svg",
         "paymentMethods":[
            {
               "id":2379,
               "name":"Payconiq",
               "description":"Payconiq",
               "translations":{
                  "name":{
                     "nl_NL":"Payconiq"
                  },
                  "description":{
                     "en_GB":"Payconiq"
                  }
               },
               "image":"/payment_methods/138.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":999999
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_2856",
         "name":"Blik",
         "translations":{
            "name":{
               "nl_NL":"Blik"
            }
         },
         "image":"/payment_methods/234.svg",
         "paymentMethods":[
            {
               "id":2856,
               "name":"Blik",
               "description":"Blik",
               "translations":{
                  "name":{
                     "nl_NL":"Blik"
                  },
                  "description":{
                     "en_GB":"Blik"
                  }
               },
               "image":"/payment_methods/234.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_436",
         "name":"Bancontact",
         "translations":{
            "name":{
               "nl_NL":"Bancontact"
            }
         },
         "image":"/payment_methods/2.svg",
         "paymentMethods":[
            {
               "id":436,
               "name":"Bancontact",
               "description":"Make a Payment trough one of the Belgium Bank that offer Bancontact",
               "translations":{
                  "name":{
                     "nl_NL":"Bancontact"
                  },
                  "description":{
                     "en_GB":"Make a Payment trough one of the Belgium Bank that offer Bancontact",
                     "nl_NL":"U kunt met Bancontact vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank, wanneer u een Belgische bankrekening heeft."
                  }
               },
               "image":"/payment_methods/2.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":1,
               "maxAmount":1000000
            }
         ],
         "requiredFields":null
      },
      {
         "tag":"PM_559",
         "name":"SOFORT",
         "translations":{
            "name":{
               "nl_NL":"SOFORT"
            }
         },
         "image":"/payment_methods/4.svg",
         "paymentMethods":[
            {
               "id":559,
               "name":"SOFORT",
               "description":"Sofortbanking",
               "translations":{
                  "name":{
                     "nl_NL":"SOFORT"
                  },
                  "description":{
                     "en_GB":"Sofortbanking",
                     "nl_NL":"Sofortbanking"
                  }
               },
               "image":"/payment_methods/4.svg",
               "options":[
                  
               ],
               "settings":null,
               "minAmount":50,
               "maxAmount":500000
            }
         ],
         "requiredFields":null
      }
   ],
   "checkoutSequence":{
      "default":{
         "primary":[
            "PG_2",
            "PM_10",
            "PM_2062",
            "PM_2151",
            "PM_2379",
            "PM_2856",
            "PM_436",
            "PM_559"
         ],
         "secondary":[
            
         ]
      }
   },
   "checkoutTexts":[
      
   ],
   "encryptionKeys":[
    
   ],
   "tguList":[
    
   ],
   "_links":[
      {
         "href":"/services/config?serviceId=SL-1234-5678",
         "rel":"self",
         "type":"GET"
      }
   ]
}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $response = $this->paynlClient->services->get();
        $this->assertInstanceOf(Service::class, $response);

        $this->assertEquals('SL-1234-5678', $response->code);
        $this->assertTrue($response->testMode);
        $this->assertEquals('Test Merchant', $response->name);
        $this->assertIsArray($response->checkoutOptions);

        $this->assertEquals([
            706 => [
                "id" => 706,
                "name" => "Visa Mastercard",
                "description" => "Make a secure payment by Creditcard",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Visa Mastercard"
                    ],
                    "description" => [
                        "en_GB" => "Make a secure payment by Creditcard",
                        "nl_NL" => "Betaal veilig met uw creditcard."
                    ]
                ],
                "image" => "/payment_methods/7.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            707 => [
                "id" => 707,
                "name" => "Postepay",
                "description" => "PostePay",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Postepay"
                    ],
                    "description" => [
                        "en_GB" => "PostePay"
                    ]
                ],
                "image" => "/payment_methods/10.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            710 => [
                "id" => 710,
                "name" => "Carte Bleue",
                "description" => "Carte Bancaire",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Carte Bleue"
                    ],
                    "description" => [
                        "en_GB" => "Carte Bancaire"
                    ]
                ],
                "image" => "/payment_methods/11.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            712 => [
                "id" => 712,
                "name" => "Maestro",
                "description" => "Maestro (Card not Present)",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Maestro"
                    ],
                    "description" => [
                        "en_GB" => "Maestro (Card not Present)",
                        "nl_NL" => "Maestro (Card not Present)"
                    ]
                ],
                "image" => "/payment_methods/6.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            1939 => [
                "id" => 1939,
                "name" => "Dankort",
                "description" => "",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Dankort"
                    ]
                ],
                "image" => "/payment_methods/58.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            1945 => [
                "id" => 1945,
                "name" => "Nexi",
                "description" => "Nexi",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Nexi"
                    ],
                    "description" => [
                        "en_GB" => "Nexi"
                    ]
                ],
                "image" => "/payment_methods/76.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            2277 => [
                "id" => 2277,
                "name" => "Apple Pay",
                "description" => "With Apple Pay you can safely, easily and privately make purchases in hundreds of thousands of stores, popular apps and online via Safari",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Apple Pay"
                    ],
                    "description" => [
                        "en_GB" => "With Apple Pay you can safely, easily and privately make purchases in hundreds of thousands of stores, popular apps and online via Safari",
                        "nl_NL" => "Met Apple Pay kun je veilig, eenvoudig en privacyvriendelijk aankopen doen."
                    ]
                ],
                "image" => "/payment_methods/114.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            2558 => [
                "id" => 2558,
                "name" => "Google Wallet",
                "description" => "Google Wallet",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Google Wallet"
                    ],
                    "description" => [
                        "en_GB" => "Google Wallet",
                        "nl_NL" => "Google Wallet"
                    ]
                ],
                "image" => "/payment_methods/176.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            10 => [
                "id" => 10,
                "name" => "iDEAL",
                "description" => "Met iDEAL kunt  u met een Nederlandse bankrekening vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank.",
                "translations" => [
                    "name" => [
                        "nl_NL" => "iDEAL"
                    ],
                    "description" => [
                        "en_GB" => "Met iDEAL kunt u met een Nederlandse bankrekening vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank."
                    ]
                ],
                "image" => "/payment_methods/1.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => [
                    [
                        "id" => "1",
                        "name" => "ABN Amro",
                        "image" => "/issuers/1.svg"
                    ],
                    [
                        "id" => "2",
                        "name" => "Rabobank",
                        "image" => "/issuers/2.svg"
                    ],
                    [
                        "id" => "4",
                        "name" => "ING",
                        "image" => "/issuers/4.svg"
                    ],
                    [
                        "id" => "5",
                        "name" => "SNS",
                        "image" => "/issuers/5.svg"
                    ],
                    [
                        "id" => "8",
                        "name" => "ASN Bank",
                        "image" => "/issuers/8.svg"
                    ],
                    [
                        "id" => "9",
                        "name" => "RegioBank",
                        "image" => "/issuers/9.svg"
                    ],
                    [
                        "id" => "10",
                        "name" => "Triodos Bank",
                        "image" => "/issuers/10.svg"
                    ],
                    [
                        "id" => "11",
                        "name" => "Van Lanschot",
                        "image" => "/issuers/11.svg"
                    ],
                    [
                        "id" => "12",
                        "name" => "Knab",
                        "image" => "/issuers/12.svg"
                    ],
                    [
                        "id" => "5080",
                        "name" => "Bunq",
                        "image" => "/issuers/5080.svg"
                    ],
                    [
                        "id" => "5084",
                        "name" => "Revolut",
                        "image" => "/issuers/5084.svg"
                    ],
                    [
                        "id" => "23355",
                        "name" => "N26",
                        "image" => "/issuers/23355.svg"
                    ],
                    [
                        "id" => "23358",
                        "name" => "Yoursafe",
                        "image" => "/issuers/23358.svg"
                    ],
                    [
                        "id" => "23361",
                        "name" => "Nationale-Nederlanden",
                        "image" => "/issuers/23361.svg"
                    ]
                ]
            ],
            2062 => [
                "id" => 2062,
                "name" => "EPS uberweisung",
                "description" => "EPS",
                "translations" => [
                    "name" => [
                        "nl_NL" => "EPS uberweisung"
                    ],
                    "description" => [
                        "de_DE" => "EPS uberweisung",
                        "en_GB" => "EPS",
                        "nl_NL" => "EPS"
                    ]
                ],
                "image" => "/payment_methods/79.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            2151 => [
                "id" => 2151,
                "name" => "Przelewy24",
                "description" => "Przelewy24",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Przelewy24"
                    ],
                    "description" => [
                        "en_GB" => "Przelewy24"
                    ]
                ],
                "image" => "/payment_methods/93.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            2379 => [
                "id" => 2379,
                "name" => "Payconiq",
                "description" => "Payconiq",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Payconiq"
                    ],
                    "description" => [
                        "en_GB" => "Payconiq"
                    ]
                ],
                "image" => "/payment_methods/138.svg",
                "minAmount" => 1,
                "maxAmount" => 999999,
                "options" => []
            ],
            2856 => [
                "id" => 2856,
                "name" => "Blik",
                "description" => "Blik",
                "translations" => [
                    "name" => [
                        "nl_NL" => "Blik"
                    ],
                    "description" => [
                        "en_GB" => "Blik",
                    ]
                ],
                "image" => "/payment_methods/234.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            436 => [
                "id" => 436,
                "name" => "Bancontact",
                "description" => 'Make a Payment trough one of the Belgium Bank that offer Bancontact',
                "translations" => [
                    "name" => [
                        "nl_NL" => "Bancontact"
                    ],
                    "description" => [
                        "en_GB" => "Make a Payment trough one of the Belgium Bank that offer Bancontact",
                        "nl_NL" => "U kunt met Bancontact vertrouwd, veilig en gemakkelijk betalen via internetbankieren van uw eigen bank, wanneer u een Belgische bankrekening heeft."
                    ]
                ],
                "image" => "/payment_methods/2.svg",
                "minAmount" => 1,
                "maxAmount" => 1000000,
                "options" => []
            ],
            559 => [
                "id" => 559,
                "name" => "SOFORT",
                "description" => "Sofortbanking",
                "translations" => [
                    "name" => [
                        "nl_NL" => "SOFORT"
                    ],
                    "description" => [
                        "en_GB" => "Sofortbanking",
                        "nl_NL" => "Sofortbanking"
                    ]
                ],
                "image" => "/payment_methods/4.svg",
                "minAmount" => 50,
                "maxAmount" => 500000,
                "options" => []
            ]
        ],
            $response->getPaymentMethods());
    }
}
