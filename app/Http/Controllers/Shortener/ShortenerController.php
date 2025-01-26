<?php

namespace App\Http\Controllers\Shortener;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUrlRequest;
use App\Http\Resources\UrlCollection;
use App\Models\Url;
use App\Services\UrlServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="Short url challenge",
 *    version="0.0.1"
 * )
 */

class ShortenerController extends Controller
{
    protected UrlServiceInterface $service;

    public function __construct(UrlServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/url",
     *     summary="Get shortened url list",
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="url_id",
     *                         type="string",
     *                         example="wgxorbna"
     *                     ),
     *                     @OA\Property(
     *                         property="url",
     *                         type="string",
     *                         example="https://swagger.io/"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404,description="no data found"),
     * )
     */
    public function index(): UrlCollection
    {
        return new UrlCollection(Url::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     *  * @OA\Post(
     *     path="/api/urls",
     *     summary="Create shortened url",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"url"},
     *                 @OA\Property(
     *                     property="url",
     *                     type="url",
     *                     example="https://swagger.io/"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204,description="success - no content"),
     *     @OA\Response(response=400,description="bad request"),
     * )
     */
    public function store(StoreUrlRequest $request)
    {
        try {
            $body = $request->validated();
            $url = new Url($body);
            $this->service->storeUrl($url);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], $e->getCode());
        }
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function redirect($id)
    {
        $redirectUrl = $this->service->getUrl($id);
        if ($redirectUrl == null) {
            return abort(404);
        }
        return redirect()->away($redirectUrl->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/url/{url_id}",
     *     summary="Delete url",
     *     @OA\Parameter(
     *         name="url_id",
     *         in="path",
     *         required=true,
     *         description="url id to delete",
     *         @OA\Schema(
     *             type="string",
     *             example="wqcoienr"
     *         )
     *     ),
     *     @OA\Response(response=200,description="success"),
     *     @OA\Response(response=404,description="url not found"),
     * )
     */
    public function destroy($id)
    {
        $result = $this->service->deleteUrl($id);
        if (!$result) {
            return abort(404);
        }
        return response()->noContent();
    }
}
