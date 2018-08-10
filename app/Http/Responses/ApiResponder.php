<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApiResponder implements ResponsesInterface
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code according to a passed int
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Respond with a validation error
     *
     * @param $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithValidationError($errors)
    {
        return $this->setStatusCode(422)->respondWithError($errors);
    }

    /**
     * Respond with a not found error
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Respond with an internal server error
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Server Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * Respond with authorization error
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondAuthorizationError($message = 'You don\'t have the rights to access this resource.')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * Respond with authentication error
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondAuthenticationError($message = 'Forbidden!')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * Respond with general error
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Respond with a message showing that the desired resource has been deleted successfully
     *
     * @param string $resourceName
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithResourceDeletedSuccessfully(string $resourceName)
    {
        return $this->respond([
            'status'    =>  'success',
            'message'   =>  "{$resourceName} has been deleted successfully"
        ]);
    }

    /**
     * General response
     *
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return \Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Respond with paginated data.
     *
     * @param LengthAwarePaginator $items
     * @param $data
     *
     * @return mixed
     */
    public function respondWithPagination(LengthAwarePaginator $items, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'current_page'  => $items->currentPage(),
                'per_page'      => $items->perPage(),
                'prev_page'     => $items->previousPageUrl() != null ?
                    (integer)explode('=', $items->previousPageUrl())[1] : null,
                'prev_page_url' => $items->previousPageUrl(),
                'next_page'     => $items->nextPageUrl() != null ?
                    (integer)explode('=', $items->nextPageUrl())[1] : null,
                'next_page_url' => $items->nextPageUrl(),
                'total' => $items->total()
            ],
            'code' => $this->getStatusCode()
        ]);

        return $this->respond($data);
    }
}