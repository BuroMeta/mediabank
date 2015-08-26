<?php
namespace Test\Picturae\Mediabank;

class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Current URL Cannot be build from CLI
     * 
     * @expectedException \Picturae\Mediabank\Exception\RuntimeException
     */
    public function testInvalidURL()
    {
        new \Picturae\Mediabank\URL();
    }
    
    /**
     * Test invalid url
     * 
     * @expectedException \Picturae\Mediabank\Exception\InvalidArgumentException
     */
    public function testInvalidArgumentURL()
    {
        new \Picturae\Mediabank\URL('foo');
    }
    
    public function testCurrentURL()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5';
        $url = new \Picturae\Mediabank\URL();
        $this->assertEquals('http://example.com/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', $url->getCurrentURL());
    }
    
    public function testGetURL()
    {
        $url = new \Picturae\Mediabank\URL('http://example.com/foo/bar');
        $this->assertEquals('http://example.com/foo/bar', $url->getURL());
    }
    
    /**
     * Test permalink
     */
    public function testIsDetail()
    {
        $url = new \Picturae\Mediabank\URL('http://example.com/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5');
        $this->assertEquals(true, $url->isDetail());
        
        $url2 = new \Picturae\Mediabank\URL('http://example.com/bla/0000b26c-76e8-0b20-9ebf-b9bb1776eae5');
        $this->assertEquals(false, $url2->isDetail());
    }
    
    /**
     * @dataProvider urlProvider
     */
    public function testGetUUID($url, $expected)
    {
        $gen = new \Picturae\Mediabank\URL($url);
        $this->assertEquals($expected, $gen->getUUID());
    }
    
    /**
     * Provide test data for url's
     * 
     * @return array
     */
    public function urlProvider()
    {
        return [
            'correct permalink' => ['http://example.com/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'correct permalink with extra path' => ['http://example.com/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5/foo', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'correct permalink with extra path and query' => ['http://example.com/detail/0000b26c-76e8-0b20-9ebf-b9bb1776eae5?foo=bar', '0000b26c-76e8-0b20-9ebf-b9bb1776eae5'],
            'incorrect permalink' => ['http://example.com/detal/0000b26c-76e8-0b20-9ebf-b9bb1776eae5', null],
        ];
    }
}
