<?php

namespace Dockent\Tests\dataProviders;

/**
 * Trait DockerfileBody
 */
trait DockerfileBody
{
    public function dataProviderGenerateBody(): array
    {
        $firstBody = <<<DOCKER
FROM busybox
WORKDIR /var/www
RUN apt-get update
CMD /bin/sh
EXPOSE 80
ENV ENVIRONMENT stage
ADD start.sh /
COPY run.sh /
VOLUME ["/var/www"]
DOCKER;

        $secondBody = <<<DOCKER
FROM busybox
WORKDIR /var/www
RUN apt-get update
RUN apt-get install nginx
CMD /bin/sh
EXPOSE 80
ENV ENVIRONMENT stage
ENV DEBUG true
ADD start.sh /
ADD run.sh /
COPY run.sh /
COPY setup.sh /
VOLUME ["/var/www","/var/settings"]
DOCKER;

        $thirdBody = <<<DOCKER
FROM busybox

RUN apt-get update
RUN apt-get install nginx
CMD /bin/sh
EXPOSE 80
ENV ENVIRONMENT stage
VOLUME ["/var/www"]
DOCKER;

        return [
            [
                [
                    'from' => 'busybox',
                    'run' => 'apt-get update',
                    'cmd' => '/bin/sh',
                    'expose' => '80',
                    'env' => 'ENVIRONMENT stage',
                    'add' => 'start.sh /',
                    'copy' => 'run.sh /',
                    'volume' => '/var/www',
                    'workdir' => '/var/www'
                ], $firstBody
            ], [
                [
                    'from' => 'busybox',
                    'run' => "apt-get update\napt-get install nginx",
                    'cmd' => '/bin/sh',
                    'expose' => '80',
                    'env' => "ENVIRONMENT stage\nDEBUG true",
                    'add' => "start.sh /\nrun.sh /",
                    'copy' => "run.sh /\nsetup.sh /",
                    'volume' => '/var/www,/var/settings',
                    'workdir' => '/var/www'
                ], $secondBody
            ], [
                [
                    'from' => 'busybox',
                    'run' => "apt-get update\napt-get install nginx",
                    'cmd' => '/bin/sh',
                    'expose' => '80',
                    'env' => "ENVIRONMENT stage",
                    'volume' => '/var/www'
                ], $thirdBody
            ]
        ];
    }
}