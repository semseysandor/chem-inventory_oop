<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | (c) Sandor Semsey <semseysandor@gmail.com>    |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 |                                               |
 | It's a free software;)                        |
 +-----------------------------------------------+
 */

/**
 * +-----------------------------------------------+
 * | This file is part of chem-inventory.          |
 * |                                               |
 * | (c) Sandor Semsey <semseysandor@gmail.com>    |
 * | All rights reserved.                          |
 * |                                               |
 * | This work is published under the MIT License. |
 * | https://choosealicense.com/licenses/mit/      |
 * |                                               |
 * | It's a free software;)                        |
 * +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\Routing;

use Inventory\Core\Exception\InvalidRequest;
use Inventory\Core\Routing\Request;
use Inventory\Test\Framework\BaseTestCase;

/**
 * RequestTest Class
 *
 * @covers \Inventory\Core\Routing\Request
 *
 * @group Routing
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class RequestTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Routing\Request
     */
    protected Request $sut;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Request();
    }

    /**
     * Object is initialized
     */
    public function testObjectInitialized()
    {
        self::assertInstanceOf(Request::class, $this->sut);
    }

    /**
     * Missing request method error
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testMissingRequestMethodThrowsInvalidRequest()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            unset($_SERVER['REQUEST_METHOD']);
        }
        self::expectException(InvalidRequest::class);
        $this->sut->parseData();
    }

    /**
     * Invalid request method error
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testInvalidRequestMethodThrowsInvalidRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'INVALID';
        self::expectException(InvalidRequest::class);
        $this->sut->parseData();
    }

    /**
     * Valid request method returns request data
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testParseDataReturnsValidRequestData()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_REQUEST = self::ARRAY;
        self::assertSame(self::ARRAY, $this->sut->parseData());

        $_REQUEST = null;
        self::assertNull($this->sut->parseData());
    }

    /**
     * Missing request URI error
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testMissingRequestURIThrowsInvalidRequest()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            unset($_SERVER['REQUEST_URI']);
        }
        self::expectException(InvalidRequest::class);
        $this->sut->parseRoute();
    }

    /**
     * Invalid request URI error
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testInvalidRequestURIThrowsInvalidRequest()
    {
        $_SERVER['REQUEST_URI'] = self::ARRAY;
        self::expectException(InvalidRequest::class);
        $this->sut->parseRoute();
    }

    /**
     * Valid request URI returns parsed route
     *
     * @throws \Inventory\Core\Exception\InvalidRequest
     */
    public function testParseRouteReturnsParsedRoute()
    {
        $_SERVER['REQUEST_URI'] = '/exec/add/batch/32';

        self::assertSame(['exec', 'add', 'batch', '32'], $this->sut->parseRoute());
    }
}
