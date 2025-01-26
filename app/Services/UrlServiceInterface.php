<?php

namespace App\Services;

use App\Models\Url;

interface UrlServiceInterface
{
    public function getUrl($id): Url|null;
    public function storeUrl(Url $url): bool;
    public function deleteUrl(string $url_id);
}
