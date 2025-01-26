<?php

namespace Tests\Unit\Services;


use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Services\UrlService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\Mock;
use Mockery\MockInterface;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    public function testGetUrl()
    {
        $id = "test-id";
        $repo = $this->mock(UrlRepository::class, function (MockInterface $mock) use ($id) {
            $url = (new Url)->fill([
                'url_id' => $id,
                'url' => "http://www.test.test",
            ]);
            $mock->shouldReceive('getUrl')->once()->andReturn($url);
        });
        $srv = new UrlService($repo);

        $result = $srv->getUrl($id);

        $this->assertNotNull($result);
        $this->assertEquals($result->url_id, $id);
    }

    public function testStoreUrl()
    {
        $url = (new Url)->fill([
            'url_id' => "test-id",
            'url' => "http://www.test.test",
        ]);

        $repo = $this->mock(UrlRepository::class, function (MockInterface $mock) use ($url) {
            $mock->shouldReceive('getUrl')->once()->andReturnNull();
            $mock->shouldReceive('storeUrl')->withArgs([$url])->once()->andReturn(true);
        });
        $srv = new UrlService($repo);

        $result = $srv->storeUrl($url);

        $this->assertTrue($result);
    }

    public function testDeleteUrl()
    {
        $url = (new Url)->fill([
            'url_id' => "test-id",
            'url' => "http://www.test.test",
        ]);
        $repo = $this->mock(UrlRepository::class, function (MockInterface $mock) use ($url) {
            $mock->shouldReceive('dropUrl')->withArgs([$url->url_id])->once()->andReturn(true);
        });
        $srv = new UrlService($repo);

        $result = $srv->deleteUrl($url->url_id);

        $this->assertTrue($result);
    }
}

