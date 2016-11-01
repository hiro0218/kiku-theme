<?php
use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use GuzzleHttp\Client;

class Kiku_Amazon {
    protected $config = null;
    protected $client = null;
    protected $request = null;

    public function __construct($accessKeyId, $secretKey, $associateId) {
        if ( empty($accessKeyId) && empty($secretKey) && empty($associateId) ) {
            return;
        }
        if ( class_exists('Client') && class_exists('GuzzleRequest') && class_exists('GenericConfiguration') ) {
            $this->client = new Client();
            $this->config = new GenericConfiguration();
            $this->config->setCountry($this->get_country())
                         ->setAccessKey($accessKeyId)
                         ->setSecretKey($secretKey)
                         ->setAssociateTag($associateId)
                         ->setRequest($this->request);
        } else {
            return;
        }
    }

    public function lookupASIN($asin) {
        if ( empty($this->config) || empty($asin) ) {
            return null;
        }

        try {
            if ( class_exists('ApaiIO') && class_exists('Lookup') ) {
                $apaiIO = new ApaiIO($this->config);
                $lookup = new Lookup();

                $lookup->setItemId($asin);
                $lookup->setResponseGroup(['ItemAttributes', 'Images']);
                $formattedResponse = $apaiIO->runOperation($lookup);

                $results = null;
                $results = simplexml_load_string( $formattedResponse );

                return $results->Items->Item;
            }
        } catch (Exception $e) {
            return null;
        }

        return null;
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
