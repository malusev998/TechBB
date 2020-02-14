<?php

namespace App\Core\Formatters;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicFormatter implements Formatter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function format($data)
    {
        if ($data instanceof Response) {
            $data->prepare($this->request)
                ->send();

            return null;
        }

        if (is_object($data) && method_exists($data, '__toString')) {
            return $data;
        }

        if (is_object($data) || is_array($data)) {
            return json_encode($data, JSON_THROW_ON_ERROR, 512);
        }

        return $data;
    }
}
