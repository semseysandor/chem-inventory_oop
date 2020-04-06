<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020                                |
 | Sandor Semsey <semseysandor@gmail.com>        |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Test\Unit\Core\Routing;

use Inventory\Core\Routing\Security;
use Inventory\Test\Framework\BaseTestCase;

/**
 * SecurityTest Class
 *
 * @covers \Inventory\Core\Routing\Security
 *
 * @group Routing
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class SecurityTest extends BaseTestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Routing\Security
     */
    protected Security $sut;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new Security();
    }

    /**
     * Test if user is not logged in
     */
    public function testUserIsNotAuthorized()
    {
        unset($_SESSION);
        self::assertFalse($this->sut->isAuthorized());
    }

    /**
     * Test if user is logged in
     */
    public function testUserIsAuthorized()
    {
        $_SESSION['USER_NAME'] = 'test';
        self::assertTrue($this->sut->isAuthorized());
    }
}
