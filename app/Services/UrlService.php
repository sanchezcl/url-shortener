<?php

namespace App\Services;

use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Repositories\UrlRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UrlService implements UrlServiceInterface
{

    const TTL = 10;
    const MAX_EXECUTIONS = 3;

    private UrlRepositoryInterface $repo;
    private int $counter = 0;

    public function __construct(UrlRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    public function getUrl($id): Url|null
    {
        return Cache::remember($id, self::TTL, function () use ($id) {
            return $this->repo->getUrl($id);
        });
    }

    /**
     * @throws \Exception
     */
    public function storeUrl(Url $url): bool
    {
        $url->url_id = $this->generateUrlID();
        $res = $this->repo->storeUrl($url);
        Cache::set($url->url_id, $url);

        return $res;
    }

    private function generateUrlID(): string
    {
        $id = Str::random(8);
        if ($this->getUrl($id) != null) {
            if ($this->counter >= self::MAX_EXECUTIONS ){
                throw new \Exception("Max execution was reached trying to generate url_id");
            }
            $this->counter++;
            return $this->generateUrlID();
        }
        return $id;
    }

    public function deleteUrl(string $url_id)
    {
        Cache::forget($url_id);
        return $this->repo->dropUrl($url_id);
    }
}
