<?php
namespace Aapapi;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use GuzzleHttp\Client;

const RETRY_COUNT = 5;
const RETRY_SLEEP_SEC = 10;

class Aapapi {
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

        $apaiIO = new ApaiIO($this->config);
        $lookup = new Lookup();
        $results = null;

        for ($i = 0 ; $i < RETRY_COUNT; $i++) {
            try {
                $lookup->setItemId($asin);
                $lookup->setResponseGroup(['ItemAttributes', 'Images']);
                $formattedResponse = $apaiIO->runOperation($lookup);
                $results = simplexml_load_string($formattedResponse);

                if ($results->Items->Request->IsValid) {
                    $results = $results->Items->Item;
                }

                break;
            } catch (Exception $e) {
                sleep(RETRY_SLEEP_SEC);
            }
        }

        return $results;
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
