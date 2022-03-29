<?php

namespace App\Exceptions;

use Core\Application\DTOs\Response\HttpResponseDTO;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Core\Infrastructure\Helpers\LogHelper;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        LogHelper::log(['request' => $request->all()], $exception, true);

        if ($exception) {
            return $this->customApiResponse($exception, $request);
        }

        return parent::render($request, $exception);
    }

    private function customApiResponse(Throwable $exception, $request)
    {
        $message = '';
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if (method_exists($exception, 'getCode')) {
            $statusCode = $exception->getCode();
        }

        switch ($statusCode) {
            case Response::HTTP_TOO_MANY_REQUESTS:
                $message = 'Too Many Attempts';
                break;
            case Response::HTTP_UNAUTHORIZED:
                $message = 'Unauthorized';
                break;
            case Response::HTTP_FORBIDDEN:
                $message = 'Forbidden';
                break;
            case Response::HTTP_NOT_FOUND:
                $message = 'Not Found';
                break;
            case Response::HTTP_METHOD_NOT_ALLOWED:
                $message = 'Method Not Allowed';
                break;
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $message[] = $exception->original['message'];
                $message[] = $exception->original['errors'];
                break;
            case Response::HTTP_BAD_REQUEST:
                $message = 'Bad Request';
                break;
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                $message = 'Internal Server Error: ' . $exception->getMessage();
                break;
        }

        return response()->json(new HttpResponseDTO($statusCode, $message), $statusCode);
    }
}
