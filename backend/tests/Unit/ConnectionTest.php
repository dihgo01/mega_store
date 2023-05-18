<?php 

use PHPUnit\Framework\TestCase;
use Database\Connection;

class ConnectionTest extends TestCase {

    /** @test */
    public function it_connects_to_the_database() {
        $pdo = Connection::connect();
        $instance_verify = is_a($pdo, 'PDO');
        $this->assertTrue($instance_verify);
    }
}