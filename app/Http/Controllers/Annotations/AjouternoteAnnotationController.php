<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\POST(
 *     path="/api/Note",
 *     summary="ajouter_note",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="path", name="date_evaluation", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="note", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="matiere_id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="etudiant_id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="date_evaluation", type="string"),
 *                     @OA\Property(property="note", type="integer"),
 *                     @OA\Property(property="etudiant_id", type="integer"),
 *                     @OA\Property(property="matiere_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"ajouter_note"},
*),


*/

 class AjouternoteAnnotationController {}
