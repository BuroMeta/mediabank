<?php
namespace Test\Picturae\Mediabank;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $key = '509544d0-1c67-11e4-9016-c788dee409dc';
    
    public function testConstruct()
    {
        new \Picturae\Mediabank\Client($this->key);
    }    
}
