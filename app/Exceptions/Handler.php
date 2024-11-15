<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorReportMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

  

    public function report(Throwable $exception)
    {
        parent::report($exception);

        if ($this->shouldReport($exception)) {
            try {
                Log::error('Reporting exception: ' . $exception->getMessage());
                Mail::to('aeroengine02@gmail.com')->send(new ErrorReportMail($exception));
            } catch (Throwable $mailException) {
                Log::error('Failed to send error report email: ' . $mailException->getMessage());
                parent::report($mailException);
            }
        }
    }
}

