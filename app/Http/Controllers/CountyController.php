<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;



class CountyController extends Controller
{

    /**
     * @api {get} /api/counties Get All Counties
     * @apiVersion 1.0.0
     * @apiName GetCounties
     * @apiGroup Counties
     * @apiPermission Authenticated User (recommended)
     *
     * @apiDescription Retrieves a list of all counties including their related cities relationship data.
     *
     * @apiSuccess {Object[]} counties List of county objects with cities relation.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "counties": [
     *         {
     *           "id": 1,
     *           "name": "Pest",
     *           "coatofarms": "pest_arms.png",
     *           "cities": [
     *             {
     *               "id": 1,
     *               "name": "Vác",
     *               "county_id": 1,
     *               "zip_code": "2600",
     *               "population": 33000
     *             }
     *           ]
     *         }
     *       ]
     *     }
     */

    public function index()
    {
        $counties = County::with('cities')->get();
        return response()->json([
            'counties' => $counties,
        ]);
    }

    /**
     * @api {post} /api/counties Create a New County
     * @apiVersion 1.0.0
     * @apiName PostCounty
     * @apiGroup Counties
     * @apiPermission Authenticated User
     *
     * @apiDescription Stores a new county record in the database.
     *
     * @apiParam {String} name Name of the county (max 255 chars).
     * @apiParam {String} coatofarms Coat of arms identifier or description/URL.
     *
     * @apiSuccess {Object} county Created county object.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Pest",
     *         "coatofarms": "pest_arms.png",
     *         "updated_at": "2026-10-05T12:00:00.000000Z",
     *         "created_at": "2026-10-05T12:00:00.000000Z"
     *       }
     *     }
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coatofarms' => 'required|string'
        ]);

        $county = County::create($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    /**
     * @api {get} /api/counties/:id Get Single County
     * @apiVersion 1.0.0
     * @apiName GetCounty
     * @apiGroup Counties
     * @apiPermission Authenticated User (recommended)
     *
     * @apiDescription Retrieves a specific county record by its ID with its related cities.
     *
     * @apiParam {Number} id County unique ID in the URL.
     *
     * @apiSuccess {Object} county County object with cities relation.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Pest",
     *         "coatofarms": "pest_arms.png",
     *         "cities": [
     *           {
     *             "id": 1,
     *             "name": "Vác",
     *             "county_id": 1,
     *             "zip_code": "2600",
     *             "population": 33000
     *           }
     *         ]
     *       }
     *     }
     */
    public function show($id)
    {
        $county = County::with('cities')->findOrFail($id);
        return response()->json([
            'county' => $county,
        ]);
    }


    /**
     * @api {put} /api/counties/:id Update County
     * @apiVersion 1.0.0
     * @apiName PutCounty
     * @apiGroup Counties
     * @apiPermission Authenticated User
     *
     * @apiDescription Updates an existing county record by its ID.
     *
     * @apiParam {Number} id County unique ID in the URL.
     * @apiParam {String} [name] Updated name of the county.
     * @apiParam {String} [coatofarms] Updated coat of arms.
     *
     * @apiSuccess {Object} county Updated county object.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": {
     *         "id": 1,
     *         "name": "Pest Updated",
     *         "coatofarms": "pest_arms_new.png"
     *       }
     *     }
     */

    public function update(Request $request, $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    /**
     * @api {delete} /api/counties/:id Delete County
     * @apiVersion 1.0.0
     * @apiName DeleteCounty
     * @apiGroup Counties
     * @apiPermission Authenticated User
     *
     * @apiDescription Deletes a specific county record by its ID.
     *
     * @apiParam {Number} id County unique ID in the URL.
     *
     * @apiSuccess {String} message Confirmation message.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "County deleted"
     *     }
     */

    public function destroy($id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted',
        ]);
    }
}
