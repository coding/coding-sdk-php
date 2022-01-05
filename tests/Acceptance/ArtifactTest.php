<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;

class ArtifactTest extends TestCase
{
    public function testUploadAndDownload()
    {
        $teamDomain = getenv('CODING_TEAM_DOMAIN');
        $projectName = $this->projectName;
        $package = 'status.txt';
        $version = date('Ymd.Hi.s', time());
        file_put_contents($package, $version);
        $http = new GuzzleClient();
        $body = Psr7\Utils::tryFopen($package, 'r');
        $url = "https://${teamDomain}-generic.pkg.coding.net/${projectName}/generic/${package}?version=${version}";
        $auth = [
            getenv('CODING_USERNAME'),
            getenv('CODING_PASSWORD'),
        ];
        $response = $http->request('PUT', $url, [
            'auth' => $auth,
            'body' => $body,
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        // Download
        $tmpfname = tempnam(sys_get_temp_dir(), $package);
        $http->request('GET', $url, [
            'auth' => $auth,
            'sink' => $tmpfname,
        ]);
        $this->assertFileEquals($package, $tmpfname);
    }
}
