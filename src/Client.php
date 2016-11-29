<?php
namespace Picturae\Mediabank;

/**
 * Picturae webkitchen client for mediabank
 * This client allows you to query the API servside
 */
class Client implements ClientInterface
{
    
    /**
     * Path where the API is located
     *
     * @var string
     */
    private $path = 'mediabank';
    
    /**
     * Client default options
     *
     * @var array
     */
    private $options = [
        'base_uri' => 'https://webservices.picturae.com',
        'headers' => [
            'apiKey' => '{apiKey}'
        ]
    ];
    
    /**
     * Mediabank API key
     * @var string
     */
    private $apiKey;
    
    /**
     * HTTP Client
     * @var \GuzzleHttp\Client
     */
    private $client;
    
    /**
     * Instantiate mediabank client.
     * To override the api url for testing purpose you can use the options parameter for the override
     * <code>
     * new Client('some-key', [
     *  'base_uri' => 'http://example.com'
     * ]);
     * </code>
     *
     * @param string $apiKey Your webkitchen API key
     * @param array $options Options override
     */
    public function __construct($apiKey, $options = null)
    {
        $this->apiKey = $apiKey;
        if ($options) {
            $this->options = array_merge($this->options, $options);
        }
    }
    
    /**
     * Get API key
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    /**
     * Get deed by uuid
     *
     * @param string $uuid
     * @return stdClass|null
     */
    public function getMedia($uuid)
    {
        $response = $this->getClient()->get($this->path . '/media/' . $uuid);
        $body = json_decode($response->getBody()->getContents());
        
        if (isset($body->media[0])) {
            return $body->media[0];
        }
    }
    
    /**
     * Get media result set
     * all parameters are optional
     *
     * self::search([
     *  'q' => 'something', // search query
     *  'rows' => 100,      // amount of rows to return
     *  'page' => 1,        // page to return
     *  'facetFields' => [  // facet's to return
     *    'search_s_place'
     *  ],
     *  'fq' => [
     *    'search_s_place: "Amsterdam"' // apply filter query
     *  ],
     *  'sort' => 'search_s_place asc'   // sort result set (default by relevance)
     * ]);
     *
     * @param array $query
     * @return \stdClass
     */
    public function search($query = [])
    {
        $response = $this->getClient()->get($this->path . '/media/', ['query' => $query]);
        $body = json_decode($response->getBody()->getContents());
        return $body;
    }

    /**
     * Get HTTP client
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }
        
        $config = $this->options;
        $config['headers']['apiKey'] = $this->apiKey;
        $this->client = new \GuzzleHttp\Client($config);
        return $this->client;
    }
}
