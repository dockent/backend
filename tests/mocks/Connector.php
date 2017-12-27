<?php

namespace Dockent\Tests\mocks;

/**
 * Class Connector
 * @package Dockent\Tests\mocks
 */
class Connector
{
    public function ImageResource()
    {
        return new class
        {
            public function imageCreate()
            {

            }

            public function build()
            {

            }
        };
    }

    public function ContainerResource()
    {
        return new class
        {
            public function containerCreate()
            {
                return json_encode(["Id" => 1]);
            }

            public function containerStart()
            {

            }

            public function containerStop()
            {

            }

            public function containerRestart()
            {

            }
        };
    }
}