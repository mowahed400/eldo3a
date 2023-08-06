<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;

class ApiController extends Controller
{
    private int $statusCode = 200;

    private bool $success;

    /**
     * @throws Exception
     */
    public function respondNotFound($code, $message = 'Not Found'): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(404)->respondWithError($message,$code);
    }

    /**
     * @throws Exception
     */
    public function respondInvalidRequest($code, $message = 'Invalid Request'): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(400)->respondWithError($message,$code);
    }

    public function respondCreated($message = 'Created Successfully',$data = []): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(201)->respondWithSuccess($message,$data);
    }

    public function respondUpdated($message = 'Updated Successfully',$data = []): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(202)->respondWithSuccess($message,$data);
    }

    /**
     * @throws Exception
     */
    public function respondInternalError($code,$message = 'Internal Server Error'): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(500)->respondWithError($message,$code);
    }

    public function respondNoContent(): \Illuminate\Http\Response
    {
        return response()->noContent();
    }

    public function respond($data, $headers = []): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithSuccess($message,array $data = []): \Illuminate\Http\JsonResponse
    {
        return $this->respond([
            'success' => $this->isSuccess(),
            'message' => $message,
            'data' => count($data) > 0 ? $data : null
        ]);
    }

    /**
     * @throws Exception
     */
    public function respondWithError($message, $code): \Illuminate\Http\JsonResponse
    {
        return $this->respond([
            'success' => $this->isSuccess(),
            'message' => $message,
            'code'    => str(str_pad($code, 3, '0', STR_PAD_LEFT))->prepend('E-'),
            'error' => getErrorByCode($code)
        ]);

    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    protected function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

}
