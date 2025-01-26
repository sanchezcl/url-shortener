<?php

namespace App\Repositories;

use App\Models\Url;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UrlRepository extends BaseRepository implements UrlRepositoryInterface
{
    const TTL = 10; // Time-to-Live (in minutes) for the cache.

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param $id
     * @return Url
     *
     */
    public function getUrl($id): Url|null
    {
        return Url::where('url_id', $id)->first();
    }

    /**
     * @param Url $url
     * @return bool
     *
     * @throws \Throwable
     */
    public function storeUrl(Url $url): bool
    {
        return $url->saveOrFail();
    }

    public function dropUrl(string $url_id): ?bool
    {
        $url = $this->getUrl($url_id);
        if ($url != null) {
            return $url->delete();
        }
        return false;
    }
}
