<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prism\Prism\Prism;

class AIController extends Controller
{
    public function test()
    {
        $response = Prism::text()
            ->using('openai', 'gpt-4.1-mini')
            ->withPrompt('Dis bonjour en français.')
            ->asText();

        return $response;
    }
}