<?php

/**
 * @OA\Info(
 *     title="title",
 *     description="description",
 *     termsOfService="termsOfService",
 *     version="version",
 *     @OA\Contact(
 *         name="contact name",
 *         url="contact url",
 *         email="contact email"
 *     ),
 *     @OA\License(
 *         name="license name",
 *         url="license url"
 *     )
 * )
 */
/** 
 * @OA\Server(
 *     description="OpenApi host",
 *     url="https://petstore.swagger-ui.io/v3"
 * )
 */
/** 
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger-ui.io"
 * )
 */
/**
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="scheme",
 *     )
 * 
 * )
 */
/**
 * @OA\Put(
 *     path="/users/{id}",
 *     summary="Updates a user",
 *     @OA\Parameter(
 *         description="Parameter with mutliple examples",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="int", value="1", summary="An int value."),
 *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="An UUID value."),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
