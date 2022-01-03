<?php

namespace ProtoneMedia\LaravelViewi;

use Illuminate\Http\Response;
use Viewi\BaseComponent;
use Viewi\WebComponents\Response as ViewiResponse;

class ViewiRequestHandler
{
    public function __construct(private BaseComponent $component)
    {
    }

    public function __invoke(): Response
    {
        $args = [];

        $component = $this->component;

        $response = $component($args);

        if (is_string($response)) {
            return response()->make($response);
        } elseif ($response instanceof ViewiResponse) {
            $content = $response->Stringify ? json_encode($response->Content) : $response->Content;

            return response()->make($content, $response->StatusCode, $response->Headers);
        }

        return response()->json($response);
    }
}
