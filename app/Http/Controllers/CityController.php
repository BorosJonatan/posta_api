<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;









class CityController extends Controller
{

    /**
     * @api {get} /api/cities Get All Cities
     * @apiVersion 1.0.0
     * @apiName GetCities
     * @apiGroup Cities
     * @apiPermission Authenticated User (recommended)
     *
     * @apiDescription Retrieves a list of all cities including their related county relationship data.
     *
     * @apiSuccess {Object[]} cities List of city objects with county relation.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "name": "Vác",
     *           "county_id": 1,
     *           "zip_code": "2600",
     *           "population": 33000,
     *           "county": {
     *             "id": 1,
     *             "name": "Pest"
     *           }
     *         }
     *       ]
     *     }
     */

    public function index()
    {
        $cities = City::with('county')->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    /**
     * @api {post} /api/cities Create a New City
     * @apiVersion 1.0.0
     * @apiName PostCity
     * @apiGroup Cities
     * @apiPermission Authenticated User
     *
     * @apiDescription Stores a new city record in the database.
     *
     * @apiParam {String} name Name of the city (max 255 chars).
     * @apiParam {Number} county_id ID of an existing county (must exist in counties table).
     * @apiParam {String} zip_code Postal/ZIP code of the city.
     * @apiParam {Number} population Total population count (integer).
     *
     * @apiSuccess {Object} city Created city object.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "city": {
     *         "id": 2,
     *         "name": "Budapest",
     *         "county_id": 5,
     *         "zip_code": "1011",
     *         "population": 1752000,
     *         "updated_at": "2026-10-05T12:00:00.000000Z",
     *         "created_at": "2026-10-05T12:00:00.000000Z"
     *       }
     *     }
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'county_id' => 'required|exists:counties,id',
            'zip_code' => 'required|string|max:255',
            'population' => 'required|integer'
        ]);

        $city = City::create($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    /**
     * @api {get} /api/cities/:id Get Single City
     * @apiVersion 1.0.0
     * @apiName GetCity
     * @apiGroup Cities
     * @apiPermission Authenticated User (recommended)
     *
     * @apiDescription Retrieves a specific city record by its ID with its related county.
     *
     * @apiParam {Number} id City unique ID in the URL.
     *
     * @apiSuccess {Object} city City object with county relation.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "name": "Vác",
     *         "county_id": 1,
     *         "zip_code": "2600",
     *         "population": 33000,
     *         "county": {
     *           "id": 1,
     *           "name": "Pest"
     *         }
     *       }
     *     }
     */

    public function show($id)
    {
        $city = City::with('county')->findOrFail($id);
        return response()->json([
            'city' => $city,
        ]);
    } 

    /**
     * @api {put} /api/cities/:id Update City
     * @apiVersion 1.0.0
     * @apiName PutCity
     * @apiGroup Cities
     * @apiPermission Authenticated User
     *
     * @apiDescription Updates an existing city record by its ID.
     *
     * @apiParam {Number} id City unique ID in the URL.
     * @apiParam {String} [name] Updated name of the city.
     * @apiParam {Number} [county_id] Updated county ID.
     * @apiParam {String} [zip_code] Updated ZIP code.
     * @apiParam {Number} [population] Updated population.
     *
     * @apiSuccess {Object} city Updated city object.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 1,
     *         "name": "Vác Updated",
     *         "county_id": 1,
     *         "zip_code": "2600",
     *         "population": 34000
     *       }
     *     }
     */

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    /**
     * @api {delete} /api/cities/:id Delete City
     * @apiVersion 1.0.0
     * @apiName DeleteCity
     * @apiGroup Cities
     * @apiPermission Authenticated User
     *
     * @apiDescription Deletes a specific city record by its ID.
     *
     * @apiParam {Number} id City unique ID in the URL.
     *
     * @apiSuccess {String} message Confirmation message.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "City deleted"
     *     }
     */

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'City deleted',
        ]);
    }
}
