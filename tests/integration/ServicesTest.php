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

namespace Inventory\Test\Integration;

use Inventory\Core\Containers\Service;
use Inventory\Entity\Compound\DAO\Compound;
use PHPUnit\Framework\TestCase;

/**
 * Services Integration Test Class
 *
 * @covers \Inventory\Core\Containers\Service
 * @covers \Inventory\Core\Settings
 * @covers \Inventory\Core\DataBase\SQLDataBase
 * @covers \Inventory\Core\Factory
 *
 * @group backend
 *
 * @category Test
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class ServicesTest extends TestCase
{
    /**
     * SUT
     *
     * @var \Inventory\Core\Containers\Service
     */
    protected Service $service;

    /**
     * Test config file
     *
     * @var string
     */
    protected string $testConfigFile = ROOT.'/../tests/integration/TestConfigFile.php';

    /**
     * Set up
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new Service();
        // Init settings with test config file
        $this->service->settings($this->testConfigFile);
    }

    /**
     * Test creating DAO using services API
     *
     * @throws \Inventory\Core\Exception\BadArgument
     * @throws \Inventory\Core\Exception\SQLException
     */
    public function testCreatingDao()
    {
        $dao = $this->service->factory()->createDaO($this->service->database(), Compound::class);
        self::assertInstanceOf(Compound::class, $dao);
    }
}
