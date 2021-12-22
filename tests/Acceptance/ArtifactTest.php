<?php

namespace Tests\Acceptance;

use Coding\Core;
use Coding\Issue;
use GuzzleHttp\Client;
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
        $client = new Client();
        $body = Psr7\Utils::tryFopen($package, 'r');
        $url = "https://${teamDomain}-generic.pkg.coding.net/${projectName}/generic/${package}?version=${version}";
        $auth = [
            getenv('CODING_USERNAME'),
            getenv('CODING_PASSWORD'),
        ];
        $response = $client->request('PUT', $url, [
            'auth' => $auth,
            'body' => $body,
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        // Download
        $tmpfname = tempnam(sys_get_temp_dir(), $package);
        $client->request('GET', $url, [
            'auth' => $auth,
            'sink' => $tmpfname,
        ]);
        $this->assertFileEquals($package, $tmpfname);
    }
}
