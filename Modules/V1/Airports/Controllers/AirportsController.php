<?php

namespace Modules\V1\Airports\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\V1\Airports\Controllers\Actions\GetAirport;
use Modules\V1\Airports\Controllers\Actions\GetAirportList;
use Modules\V1\Airports\Controllers\Actions\CreateAnAirport;
use Modules\V1\Airports\Controllers\Actions\UpdateAnAirport;
use Modules\V1\Airports\Controllers\Actions\DeleteAnAirport;

class AirportsController extends Controller
{
    /**
     * @param GetAirportList $action
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/api/v1/airports",
     *      summary="Get a list of airports",
     *      tags={"Airports"},
     *
     *       @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Application language",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="string",
     *             enum={"en", "de"},
     *             default="en"
     *         )
     *       ),
     *      @OA\Parameter(
     *          name="paginated",
     *          in="query",
     *          description="Pagination indicator (1 for paginated results, 0 for all results)",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *              enum={0, 1},
     *              default=1
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Number of items per page (applicable when 'paginated' is 1)",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="integer",
     *              default=5
     *          )
     *      ),
     *      @OA\Parameter(
     *           name="page",
     *           in="query",
     *           description="Number of page",
     *           required=false,
     *
     *           @OA\Schema(
     *               type="integer",
     *               default=1
     *           )
     *       ),
     *      @OA\Parameter(
     *            name="airport_name",
     *            in="query",
     *            description="name of the airport",
     *            required=false,
     *
     *            @OA\Schema(
     *                type="string",
     *            )
     *        ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="List of airports retrieved successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *
     *                  @OA\Items(
     *                      type="object",
     *
     *                      @OA\Property(property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"),
     *                      @OA\Property(property="airport_id", type="integer", example=100),
     *                      @OA\Property(property="latitude", type="integer", example="90"),
     *                      @OA\Property(property="longitude", type="integer", example="180"),
     *                      @OA\Property(property="iata", type="string", example="111"),
     *                      @OA\Property(property="details", type="object",
     *                      @OA\Property(
     *                          property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"
     *                      ),
     *                      @OA\Property(
     *                           property="name", type="string", example="London"
     *                       ),
     *                      @OA\Property(
     *                          property="language", type="string", enum={"en", "de"} ,example="en"
     *                       ),
     *                      @OA\Property(
     *                         property="description", type="string", example="descriptoion"
     *                      ),
     *                      @OA\Property(
     *                         property="terms_of_conditions", type="string", example="some extra info"
     *                      )),
     *                  )
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Airport not found!"
     *      )
     *  )
     */
    public function index(GetAirportList $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @param GetAirport $action
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *       path="/api/v1/airports/{airport}",
     *       summary="Get an airport",
     *       tags={"Airports"},
     *
     *      @OA\Parameter(
     *          name="Accept-Language",
     *          in="header",
     *          description="Application language",
     *          required=false,
     *
     *          @OA\Schema(
     *              type="string",
     *              enum={"en", "de"},
     *              default="en"
     *          )
     *        ),
     *
     *       @OA\Response(
     *           response=200,
     *           description="List of airports retrieved successfully",
     *
     *           @OA\JsonContent(
     *               type="object",
     *
     *               @OA\Property(
     *                   property="data",
     *                   type="array",
     *
     *                   @OA\Items(
     *                       type="object",
     *
     *                       @OA\Property(property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"),
     *                       @OA\Property(property="airport_id", type="integer", example=100),
     *                       @OA\Property(property="latitude", type="integer", example="90"),
     *                       @OA\Property(property="longitude", type="integer", example="180"),
     *                       @OA\Property(property="iata", type="string", example="111"),
     *                       @OA\Property(property="details", type="object",
     *                       @OA\Property(
     *                           property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"
     *                       ),
     *                       @OA\Property(
     *                            property="name", type="string", example="London"
     *                        ),
     *                       @OA\Property(
     *                           property="language", type="string", enum={"en", "de"} ,example="en"
     *                        ),
     *                       @OA\Property(
     *                          property="description", type="string", example="descriptoion"
     *                       ),
     *                       @OA\Property(
     *                          property="terms_of_conditions", type="string", example="some extra info"
     *                       )),
     *                   )
     *               )
     *           )
     *       ),
     *
     *       @OA\Response(
     *           response=404,
     *           description="Airport not found!"
     *       )
     *   )
     */
    public function show(GetAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @param CreateAnAirport $action
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *      path="/api/v1/airports",
     *      summary="Create An Airport",
     *      description="Create An Airport.",
     *      tags={"Airports"},
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="form-data",
     *
     *              @OA\Schema(
     *                  type="object",
     *
     *                  @OA\Property(
     *                      property="airport_id",
     *                      type="string",
     *                      description="airport Id."
     *                  ),
     *                  @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       description="airport name."
     *                   ),
     *                  @OA\Property(
     *                        property="latitude",
     *                        type="integer",
     *                        description="latitude"
     *                    ),
     *                  @OA\Property(
     *                         property="longitude",
     *                         type="integer",
     *                         description="latitude"
     *                     ),
     *                  @OA\Property(
     *                        property="iata_code",
     *                        type="string",
     *                        description="latitude"
     *                    ),
     *                 @OA\Property(
     *                   property="description",
     *                   type="string",
     *                   description="description"
     *                 ),
     *                 @OA\Property(
     *                    property="terms_and_conditions",
     *                    type="string",
     *                    description="Terms and conditions"
     *                  ),
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *            response=200,
     *            description="Airport created successfully",
     *
     *            @OA\JsonContent(
     *                type="object",
     *
     *                @OA\Property(
     *                    property="data",
     *                    type="array",
     *
     *                    @OA\Items(
     *                        type="object",
     *
     *                        @OA\Property(property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"),
     *                        @OA\Property(property="airport_id", type="integer", example=100),
     *                        @OA\Property(property="latitude", type="integer", example="90"),
     *                        @OA\Property(property="longitude", type="integer", example="180"),
     *                        @OA\Property(property="iata", type="string", example="111"),
     *                        @OA\Property(property="details", type="object",
     *                        @OA\Property(
     *                            property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"
     *                        ),
     *                        @OA\Property(
     *                             property="name", type="string", example="London"
     *                         ),
     *                        @OA\Property(
     *                            property="language", type="string", enum={"en", "de"} ,example="en"
     *                         ),
     *                        @OA\Property(
     *                           property="description", type="string", example="descriptoion"
     *                        ),
     *                        @OA\Property(
     *                           property="terms_of_conditions", type="string", example="some extra info"
     *                        )),
     *                    )
     *                )
     *            )
     *        ),
     *
     *    )
     */
    public function store(CreateAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @param UpdateAnAirport $action
     *
     * @return JsonResponse
     *
     * @OA\Patch(
     *       path="/api/v1/airports/{aiorport}",
     *       summary="Update An Airport",
     *       description="Update An Airport.",
     *       tags={"Airports"},
     *
     *       @OA\RequestBody(
     *           required=true,
     *
     *           @OA\MediaType(
     *               mediaType="form-data",
     *
     *               @OA\Schema(
     *                   type="object",
     *
     *                   @OA\Property(
     *                       property="airport_id",
     *                       type="string",
     *                       description="airport Id."
     *                   ),
     *                   @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="airport name."
     *                    ),
     *                   @OA\Property(
     *                         property="latitude",
     *                         type="integer",
     *                         description="latitude"
     *                     ),
     *                   @OA\Property(
     *                          property="longitude",
     *                          type="integer",
     *                          description="latitude"
     *                      ),
     *                   @OA\Property(
     *                         property="iata_code",
     *                         type="string",
     *                         description="latitude"
     *                     ),
     *                  @OA\Property(
     *                    property="description",
     *                    type="string",
     *                    description="description"
     *                  ),
     *                  @OA\Property(
     *                     property="terms_and_conditions",
     *                     type="string",
     *                     description="Terms and conditions"
     *                   ),
     *               )
     *           )
     *       ),
     *
     *       @OA\Response(
     *             response=200,
     *             description="Airport updated successfully",
     *
     *             @OA\JsonContent(
     *                 type="object",
     *
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *
     *                     @OA\Items(
     *                         type="object",
     *
     *                         @OA\Property(property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"),
     *                         @OA\Property(property="airport_id", type="integer", example=100),
     *                         @OA\Property(property="latitude", type="integer", example="90"),
     *                         @OA\Property(property="longitude", type="integer", example="180"),
     *                         @OA\Property(property="iata", type="string", example="111"),
     *                         @OA\Property(property="details", type="object",
     *                         @OA\Property(
     *                             property="id", type="string", example="0001a9bd-9064-4ad9-9e7b-651e253d1e19"
     *                         ),
     *                         @OA\Property(
     *                              property="name", type="string", example="London"
     *                          ),
     *                         @OA\Property(
     *                             property="language", type="string", enum={"en", "de"} ,example="en"
     *                          ),
     *                         @OA\Property(
     *                            property="description", type="string", example="descriptoion"
     *                         ),
     *                         @OA\Property(
     *                            property="terms_of_conditions", type="string", example="some extra info"
     *                         )),
     *                     )
     *                 )
     *             )
     *         ),
     *
     *     )
     * /
     */
    public function update(UpdateAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @param DeleteAnAirport $action
     *
     * @return JsonResponse
     *
     * @OA\Delete(
     *      path="/api/v1/airports/{airport}",
     *      summary="Delete an airport by ID",
     *      tags={"Airports"},
     *
     *      @OA\Parameter(
     *          name="airport",
     *          in="path",
     *          description="ID of the airport to delete",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Airport deleted successfully",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Airport deleted successfully."
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Airport not found!"
     *      )
     *  )
     * /
     */
    public function destroy(DeleteAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
