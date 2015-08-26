<?php
namespace Picturae\Mediabank;

interface ClientInterface
{
    /**
     * Get media by id
     *
     * @param string $uuid
     * @return \stdClass|null
     */
    public function getMedia($uuid);

    /**
     * Get media result set
     *
     * @param array $query
     * @return \stdClass
     */
    public function search($query);

    /**
     * Get api key
     *
     * @return string
     */
    public function getApiKey();
}
