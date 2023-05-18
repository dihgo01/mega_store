<?php 

use PHPUnit\Framework\TestCase;
use Database\Connection;

class ConnectionTest extends TestCase {

    /** @test */
    public function it_connects_to_the_database() {
        $config = require 'config.php';
        $pdo = Connection::connect($config['database']);
        $this->assertInstanceOf(PDO::class, $pdo);
    }
}