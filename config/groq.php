<?php

return [
    /*
    |--------------------------------------------------------------------------
    | GROQ API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration settings for the GROQ API integration.
    | Make sure to set the corresponding values in your .env file.
    |
    */

    'api_key' => env('GROQ_API_KEY'),
    'endpoint' => env('GROQ_ENDPOINT', 'https://api.groq.com/openai/v1/chat/completions'),
    'model' => env('GROQ_MODEL', 'llama3-8b-8192'),
    
    'timeout' => env('GROQ_TIMEOUT', 30),
    'max_tokens' => env('GROQ_MAX_TOKENS', 2048),
    
    'options' => [
        'temperature' => env('GROQ_TEMPERATURE', 0.7),
        'top_p' => env('GROQ_TOP_P', 1.0),
        'frequency_penalty' => env('GROQ_FREQUENCY_PENALTY', 0.0),
        'presence_penalty' => env('GROQ_PRESENCE_PENALTY', 0.0),
    ],
];

$apiKey = config('groq.api_key');
$endpoint = config('groq.endpoint');
$model = config('groq.model');