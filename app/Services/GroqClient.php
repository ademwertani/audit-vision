<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqClient
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $defaultModel;
    protected mixed  $verifyOption; // bool|string (chemin cacert)

    public function __construct()
    {
        $this->apiKey       = (string) config('services.groq.key', '');
        $this->baseUrl      = rtrim((string) config('services.groq.base', 'https://api.groq.com/openai/v1'), '/');
        $this->defaultModel = (string) config('services.groq.model', 'llama-3.1-70b-versatile');

        // ---- Détermine l’option verify (CA path ou bool) ----
        // 1) Si un chemin CA est fourni et existe, on l’utilise
        $caRel = (string) config('services.groq.ca', '');
        $caAbs = $caRel ? base_path(trim($caRel, '/\\')) : '';
        if ($caAbs && is_file($caAbs)) {
            $this->verifyOption = $caAbs; // ex: storage/certs/cacert.pem
        } else {
            // 2) Sinon, on lit le flag d’env (true/false). En local tu peux mettre false TEMPORAIREMENT.
            $verifyFromEnv = config('services.groq.verify', true);
            // Sécurité: en prod on force true
            $this->verifyOption = app()->environment('production') ? true : (bool) $verifyFromEnv;

            // 3) Petit fallback: si le fichier standard existe, on l’utilise
            if ($this->verifyOption === true) {
                $fallback = storage_path('certs/cacert.pem');
                if (is_file($fallback)) {
                    $this->verifyOption = $fallback;
                }
            }
        }
    }

    /**
     * @param array<int,array{role:string,content:string}> $messages
     * @param array<string,mixed> $options
     * @return string Réponse de l'assistant (texte)
     * @throws \RuntimeException si configuration manquante
     */
    public function chat(array $messages, array $options = []): string
    {
        if (empty($this->apiKey)) {
            throw new \RuntimeException('GROQ_API_KEY manquante. Ajoute-la dans .env puis php artisan config:clear');
        }

        $model = $options['model'] ?? $this->defaultModel;

        $payload = [
            'model'       => $model,
            'messages'    => $messages,
            'temperature' => $options['temperature'] ?? 0.3,
            'max_tokens'  => $options['max_tokens']  ?? 512,
        ];

        try {
            $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$this->apiKey,
                    'Content-Type'  => 'application/json',
                ])
                // >>>>>>> ICI on règle cURL error 60
                ->withOptions(['verify' => $this->verifyOption])
                // <<<<<<<
                ->timeout(30)
                ->post($this->baseUrl.'/chat/completions', $payload);

            if (!$response->successful()) {
                Log::error('[Groq] HTTP error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                $msg = 'Erreur Groq (HTTP '.$response->status().')';
                $j = $response->json();
                if (is_array($j) && isset($j['error']['message'])) {
                    $msg .= ': '.$j['error']['message'];
                }
                throw new \RuntimeException($msg);
            }

            $json = $response->json();
            $content = $json['choices'][0]['message']['content'] ?? '';

            if ($content === '') {
                Log::warning('[Groq] Réponse vide ou mal formée', ['json' => $json]);
                $content = '(réponse vide)';
            }

            return $content;

        } catch (\Throwable $e) {
            Log::error('[Groq] Exception', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
