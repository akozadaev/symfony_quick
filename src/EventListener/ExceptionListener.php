<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        // Вы получаете объект исключения из полученного события
        $exception = $event->getThrowable();
        $message = sprintf(
            'Error: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Настройте ваш объект ответа, чтобы он отображал детали исключений
        $response = new Response();
        $response->setContent($message);
        // сообщение об исключении может содержать нефильтрованный пользовательский ввод;
        // тип содержания как text, чтобы избежать XSS-проблем
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        // HttpExceptionInterface - это специальный тип исключения, который
        // содержит статус кода и детали заголовка
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Отправляет изменённый объект ответа событию
        $event->setResponse($response);
    }
}