<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\Client;

use Devmachine\Bundle\OntheioBundle\Client\Image\Result;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceAndGetters()
    {
        $result = new Result('abc', 200, 150, 'http://abc.url', true);

        $this->assertEquals('abc', $result->getKey());
        $this->assertEquals(200, $result->getWidth());
        $this->assertEquals(150, $result->getHeight());
        $this->assertEquals('http://abc.url', $result->getUrl());
        $this->assertEquals('200x150', $result->getSize());
        $this->assertTrue($result->isNew());
    }

    public function testCreateNew()
    {
        $data = [
            'key' => 'abc',
            'size' => '200x150',
            'full_size' => 'http://abc.url',
        ];

        $result = Result::create($data);

        $this->assertEquals($data['key'], $result->getKey());
        $this->assertEquals(200, $result->getWidth());
        $this->assertEquals(150, $result->getHeight());
        $this->assertEquals($data['full_size'], $result->getUrl());
        $this->assertTrue($result->isNew());
    }

    public function testCreateExisting()
    {
        $data = [
            'key' => 'abc',
            'size' => '200x150',
            'full_size' => 'http://abc.url',
            'uploaded_before' => true,
        ];

        $this->assertFalse(Result::create($data)->isNew());
    }
}
