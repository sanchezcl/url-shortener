<?php

namespace Tests\Unit\Repositories;

use App\Models\Url;
use App\Repositories\UrlRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Testing\Fakes\Fake;
use Mockery;
use Tests\TestCase;

class UrlRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testGetUrl_GivenAnUrlID_WhenGettingUrlAndWasNotFound_ThenReturnNull()
    {
        $id = 'test-url-id-not-found';
        $url = new Url();
        $repo = new UrlRepository($url);

        $result = $repo->getUrl($id);

        $this->assertNull($result);
    }

    public function testGetUrl_GivenAnUrlID_WhenGettingUrl_ThenReturnUrlModel()
    {
        $id = 'test-url-id';
        $url = new Url();
        $repo = new UrlRepository();

        $result = $repo->getUrl($id);

        $this->assertNotNull($result);
        $this->assertEquals($result::class, $url::class);
        $this->assertEquals($result->url_id, $id);
    }

    public function testStoreUrl_GivenAnUrlModel_WhenStoreUrl_ThenReturnNoError()
    {

        $url = new Url([
            'url_id' => "store-test-id",
            'url' => "http://www.test.test",
        ]);
        $repo = new UrlRepository();

        $result = $repo->storeUrl($url);

        $this->assertNotNull($result);
        $this->assertTrue($result);
    }

    public function testDropUrl_GivenUrlID_WhenDeleteingRow_ThenReturnNoError()
    {
        $repo = new UrlRepository();
        $id = 'test-url-delete';

        $result = $repo->dropUrl($id);

        $this->assertTrue($result);
    }
}
