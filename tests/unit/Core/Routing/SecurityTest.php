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
use Inventory\Core\Routing\SessionManager;
use Inventory\Test\Framework\BaseTestCase;

/**
 * SecurityTest Class
 *
 * @covers \Inventory\Core\Routing\Security
 *
 * @group routing
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
        $session_manager = $this->getMockBuilder(SessionManager::class)->getMock();
        $this->sut = new Security($session_manager);
    }

    /**
     * Test if user is not logged in
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function testUserIsNotAuthorized()
    {
        unset($_SESSION);
        self::assertFalse($this->sut->isAuthenticated());

        $_SESSION['AUTH'] = false;
        self::assertFalse($this->sut->isAuthenticated());
    }

    /**
     * Test if user is logged in
     *
     * @throws \Inventory\Core\Exception\AuthorizationException
     */
    public function testUserIsAuthorized()
    {
        $_SESSION['AUTH'] = true;
        self::assertTrue($this->sut->isAuthenticated());
    }
}
