<?php

namespace Ride\Tests\Integration;

use PHPUnit\Framework\TestCase;

class RequestRideTest extends TestCase
{
    public function testExecute()
    {
        $connection = new MysqlPromiseAdapter();
        $accountGateway = new AccountGatewayHttp();
        $rideRepository = new RideRepoitoryDatabase($connection);
        $input = new RequestRideInput();

    }
}