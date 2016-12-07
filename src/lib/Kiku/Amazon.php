<?php
namespace Kiku;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use GuzzleHttp\Client;

class Amazon {
    protected $config = null;
    protected $client = null;
    protected $request = null;

    public function __construct($accessKeyId, $secretKey, $associateId) {
        if ( empty($accessKeyId) || empty($secretKey) || empty($associateId) ) {
            return;
        }

        $this->client = new Client();
        $this->request = new GuzzleRequest($this->client);
        $this->config = new GenericConfiguration();
        $this->config->setCountry($this->get_country())
                     ->setAccessKey($accessKeyId)
                     ->setSecretKey($secretKey)
                     ->setAssociateTag($associateId)
                     ->setRequest($this->request);
    }

    public function lookupASIN($asin) {
        if ( !$asin || !$this->config ) {
            return null;
        }

        try {
            $results = null;
            $apaiIO = new ApaiIO($this->config);
            $lookup = new Lookup();

            $lookup->setItemId($asin);
            $lookup->setResponseGroup(['ItemAttributes', 'Images']);
            $formattedResponse = $apaiIO->runOperation($lookup);
            $results = simplexml_load_string( $formattedResponse );

            return $results->Items->Item;
        } catch (Exception $e) {
            return null;
        }

    }

    private function get_country() {
        $lang = get_locale();
        $country = '';

        switch ($lang) {
            case 'en_GB':
            $country = 'co.uk';
            break;
            case 'ja':
            $country = 'co.jp';
            break;
            default:  // en_US
            $country = 'com';
            break;
        }

        return $country;
    }
}
