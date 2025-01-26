<?php

namespace App\Repositories;

use App\Models\Url;

interface UrlRepositoryInterface
{
    public function getAll();
    public function getUrl($id): Url|null;
    public function storeUrl(Url $url): bool;
    public function dropUrl(string $url_id);
}
