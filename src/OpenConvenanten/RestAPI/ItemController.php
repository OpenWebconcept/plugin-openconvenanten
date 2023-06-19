<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\RestAPI;

use WP_Error;
use WP_Query;
use WP_REST_Request;
use Yard\OpenConvenanten\Foundation\Plugin;
use Yard\OpenConvenanten\Repository\OpenConvenantenRepository;
use Yard\OpenConvenanten\RestAPI\Filters\FactoryFilter;

class ItemController
{
    /**
     * Instance of the plugin.
     *
     * @var Plugin
     */
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Merges a paginator, based on a WP_Query, inside a data arary.
     */
    protected function addPaginator(array $data, WP_Query $query): array
    {
        $page = $query->get('paged');
        $page = 0 == $page ? 1 : $page;

        return array_merge([
            'data' => $data,
        ], [
            'pagination' => [
                'total_count' => (int) $query->found_posts,
                'total_pages' => (int) $query->max_num_pages,
                'current_page' => (int) $page,
                'limit' => (int) $query->get('posts_per_page'),
                'query_parameters' => $query->query,
            ],
        ]);
    }


    /**
     * Get the paginator query params for a given query.
     */
    protected function getPaginatorParams(WP_REST_Request $request, int $limit = 10): array
    {
        return array_merge($request->get_params(), [
            'posts_per_page' => (int) $request->get_param('limit') ?: ($request->get_param('per_page') ?: $limit),
            'paged' => $request->get_param('page') ?: 0,
        ]);
    }

    /**
     * @param WP_REST_Request $request
     *
     * @return \Yard\OpenConvenanten\RestAPI\Response
     *
     * @throws \Yard\OpenConvenanten\Exceptions\PropertyNotExistsException
     * @throws \ReflectionException
     *
     *  @OA\Get(
     *    path="/items",
     *    operationId="getItems",
     *    description="Get all openConvenanten items",
     *
     *    @OA\Parameter(
     *      name="filter[]",
     *      in="query",
     *      description="Filter items by date of modification",
     *      example="updatedAfterDate:2021-03-01",
     *      required=false,
     *
     *      @OA\Schema(
     *        type="array",
     *        pattern="updatedAfterDate:YYYY-MM-DD",
     *
     *        @OA\Items(type="string"),
     *      )
     *    ),
     *
     *    @OA\Parameter(
     *      name="filter[]",
     *      in="query",
     *      description="Filter items by date of publication",
     *      example="publishedAfterDate:2021-03-01",
     *      required=false,
     *
     *      @OA\Schema(
     *        type="array",
     *        pattern="publishedAfterDate:YYYY-MM-DD",
     *
     *        @OA\Items(type="string"),
     *
     *      )
     *    ),
     *
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *
     *      @OA\JsonContent(
     *        ref="#/components/schemas/Response"
     *      ),
     *   ),
     *    tags={
     *      "API"
     *    }
     * )
     */
    public function getItems(WP_REST_Request $request): Response
    {
        $items = (new OpenConvenantenRepository())
            ->query(apply_filters('yard/openconvenanten/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query(apply_filters('yard/openconvenanten/rest-api/items/query', $this->getFilters($request)));

        if ($this->showOnParamIsValid($request)) {
            $items->query(OpenConvenantenRepository::addShowOnParameter($request->get_param('source')));
        }

        $data = $items->all();

        return new Response([
            'Convenantenverzoeken' => $data,
        ], $items->getQuery());
    }

    public function getLatestItems(WP_REST_Request $request): Response
    {
        $items = (new OpenConvenantenRepository())
            ->query(apply_filters('yard/openconvenanten/rest-api/items/query', $this->getFilters($request)));

        $data = $items->latest();

        return new Response([
            'Convenantenverzoeken' => $data,
        ], $items->getQuery());
    }

    protected function getFilters(WP_REST_Request $request): array
    {
        $filters = array_filter(array_map(function ($filter) {
            return FactoryFilter::resolve($filter)->get();
        }, $request->get_param('filter') ?? []));

        $filters = array_merge_recursive([], array_map(function ($filter) {
            return $filter->getQuery();
        }, $filters));

        return $filters[0] ?? $filters;
    }

    /**
     * @param WP_REST_Request $request $request
     *
     * @return Response|WP_Error
     *
     * @throws \Yard\OpenConvenanten\Exceptions\PropertyNotExistsException
     * @throws \ReflectionException
     *
     *  @OA\Get(
     *    path="/items/{UUID}",
     *    operationId="getItem",
     *    description="Get openConvenanten item by UUID",
     *
     *    @OA\Parameter(
     *      name="UUID",
     *      in="path",
     *      description="UUID of OpenConvenanten item",
     *       example="/36aea3a9-e1d8-407a-8ea3-4617856f97fc",
     *      required=true,
     *
     *      @OA\Schema(
     *        type="string",
     *        format="uuid"
     *      )
     *    ),
     *
     *    @OA\Response(
     *      response="200",
     *      description="OK",
     *
     *      @OA\JsonContent(
     *        type="object",
     *        ref="#/components/schemas/OpenConvenanten",
     *
     *        @OA\Link(link="OpenConvenantenRepository", ref="#/components/links/OpenconvenantenRepository"),
     *
     *        @OA\Examples(example=200, summary="", value={"name":1})
     *     ),
     *   ),
     *
     *    @OA\Response(
     *      response="404",
     *      description="OpenConvenanten not found",
     *
     *      @OA\JsonContent(
     *        type="object",
     *      ),
     *   ),
     *   tags={
     *     "API"
     *   }
     * )
     */
    public function getItem(WP_REST_Request $request)
    {
        $slug = (string) $request->get_param('slug');

        $item = (new OpenConvenantenRepository)
            ->query(apply_filters('yard/openconvenanten/rest-api/items/query/single', $request->get_params()));
        $data = $item->findBySlug($slug);

        if (! $data) {
            return new WP_Error('no_item_found', sprintf('Item with slug "%s" not found (anymore)', $slug), [
                'status' => 404,
            ]);
        }

        return new Response([
            'Convenantenverzoeken' => [
                $data,
            ],
        ], $item->getQuery());
    }

    /**
     * Validate if show on param is valid.
     * Param should be a numeric value.
     */
    protected function showOnParamIsValid(WP_REST_Request $request): bool
    {
        if (empty($request->get_param('source'))) {
            return false;
        }

        if (! is_numeric($request->get_param('source'))) {
            return false;
        }

        return true;
    }
}
