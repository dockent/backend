<?php

namespace Dockent\Tests\mocks;

use Http\Client\Exception\HttpException;

/**
 * Class Connector
 * @package Dockent\Tests\mocks
 */
class Connector extends \Dockent\Connector\Connector
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

            public function imageList()
            {
                return json_encode(['status' => 'success']);
            }

            /**
             * @param string $id
             * @throws \Exception
             */
            public function imageDelete(string $id)
            {
                if ($id === 'exception') {
                    throw new \Exception();
                }
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

            public function containerList()
            {
                return json_encode(['status' => 'success']);
            }

            public function containerDelete()
            {

            }

            public function containerInspect($id = null)
            {
                if ($id === 'view404') {
                    throw new HttpException('Not Found', new Requests(), new Response());
                }
                return json_encode(['State' => ['Status' => 'running']]);
            }

            public function containerTop()
            {

            }

            public function containerRename()
            {

            }
        };
    }

    public function SystemResource()
    {
        return new class
        {
            public function systemInfo()
            {
                return json_encode(['status' => 'success']);
            }
        };
    }

    public function NetworkResource()
    {
        return new class
        {
            public function networkList()
            {
                return json_encode(['status' => 'success']);
            }

            /**
             * @param string $id
             * @throws \Exception
             */
            public function networkDelete(string $id)
            {
                if ($id === 'exception') {
                    throw new \Exception();
                }
            }

            public function networkInspect($id = null)
            {
                if ($id === 'view404') {
                    throw new HttpException('Not Found', new Requests(), new Response());
                }
                return json_encode(['status' => 'success']);
            }

            public function networkCreate()
            {

            }
        };
    }
}