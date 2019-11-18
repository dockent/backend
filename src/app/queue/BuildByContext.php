<?php

namespace Dockent\queue;

use Dockent\components\docker\BodyGenerator;

/**
 * Class BuildByContext
 * @package Dockent\queue
 */
class BuildByContext extends QueueAction
{
    /**
     * @var BuildByDockerfileBody
     */
    private $buildAction;

    /**
     * @var BodyGenerator
     */
    private $bodyGenerator;

    /**
     * BuildByContext constructor.
     *
     * @param BodyGenerator         $bodyGenerator
     * @param BuildByDockerfileBody $buildAction
     */
    public function __construct(BodyGenerator $bodyGenerator, BuildByDockerfileBody $buildAction)
    {
        $this->buildAction = $buildAction;
        $this->bodyGenerator = $bodyGenerator;
    }

    public function handle(): void
    {
        $body = $this->bodyGenerator->generateBody($this->data);
        $this->buildAction->setData($body)->handle();
    }
}