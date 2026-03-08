<?php

namespace App\Services;

use App\Models\Submission;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAnalyzer
{
    public function analyze(Submission $submission): array
    {
        $key   = config('services.openai.key');
        $model = 'gpt-4.1-mini';

        $text = $submission->answers
            ->map(fn($a) => $a->question->contenido . ": " . $a->contenido)
            ->implode("\n");

        if (!$key) {
            Log::warning('OpenAI key missing -> using mock');
            return $this->mock($text);
        }

        try {
            $payload = [
                'model' => $model,
                'input' => [
                    [
                        'role' => 'system',
                        'content' => 'Eres un analista de reseñas. Devuelve SOLO JSON válido y nada más.',
                    ],
                    [
                        'role' => 'user',
                        'content' =>
                            "Analiza esta respuesta de encuesta y genera:\n".
                            "- sentiment: positivo|neutral|negativo\n".
                            "- severity: bueno|regular|critico\n".
                            "- summary: 1-2 frases\n".
                            "- improvements: lista (1-6 ítems)\n\n".
                            "TEXTO:\n".$text
                    ],
                ],
                'response_format' => [
                    'type' => 'json_schema',
                    'json_schema' => [
                        'name' => 'ai_report',
                        'strict' => true,
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'sentiment' => [
                                    'type' => 'string',
                                    'enum' => ['positivo', 'neutral', 'negativo'],
                                ],
                                'severity' => [
                                    'type' => 'string',
                                    'enum' => ['bueno', 'regular', 'critico'],
                                ],
                                'summary' => [
                                    'type' => 'string',
                                ],
                                'improvements' => [
                                    'type' => 'array',
                                    'items' => ['type' => 'string'],
                                    'minItems' => 0,
                                    'maxItems' => 6,
                                ],
                            ],
                            'required' => ['sentiment', 'severity', 'summary', 'improvements'],
                            'additionalProperties' => false,
                        ],
                    ],
                ],
            ];

            /** @var Response $res */
            $res = Http::withToken($key)
                ->timeout(25)
                ->post('https://api.openai.com/v1/responses', $payload);

            if (!$res->successful()) {
                Log::warning('OpenAI failed', [
                    'status' => $res->status(),
                    'body' => $res->body(),
                ]);
                return $this->mock($text);
            }

            $json = $this->extractJson($res->json());

            $improvements = $json['improvements'] ?? [];
            if (!is_array($improvements)) $improvements = [];
            $improvements = array_values(array_filter($improvements, fn($x) => is_string($x) && trim($x) !== ''));

            return [
                'sentiment' => $json['sentiment'] ?? 'neutral',
                'severity' => $json['severity'] ?? 'regular',
                'summary' => $json['summary'] ?? 'Resumen no disponible.',
                'improvements' => $improvements,
            ];
        } catch (\Throwable $e) {
            Log::error('OpenAI exception', ['e' => $e->getMessage()]);
            return $this->mock($text);
        }
    }

    private function extractJson(array $response): array
    {
        // Responses API suele traer esto si la salida final es texto
        $outputText = $response['output_text'] ?? null;

        if (is_string($outputText)) {
            $decoded = json_decode($outputText, true);
            if (is_array($decoded)) return $decoded;
        }

        // Fallback típico: output[0].content[0].text
        $maybe = $response['output'][0]['content'][0]['text'] ?? null;
        if (is_string($maybe)) {
            $decoded = json_decode($maybe, true);
            if (is_array($decoded)) return $decoded;
        }

        return [];
    }

    private function mock(string $text): array
    {
        Log::warning('Using AI MOCK fallback');

        $t = mb_strtolower($text);

        $sentiment = (str_contains($t, 'bien') || str_contains($t, 'excelente') || str_contains($t, 'encant'))
            ? 'positivo'
            : ((str_contains($t, 'mal') || str_contains($t, 'pesim')) ? 'negativo' : 'neutral');

        $severity = (str_contains($t, 'bug') || str_contains($t, 'error') || str_contains($t, 'no funciona'))
            ? 'critico'
            : 'regular';

        return [
            'sentiment' => $sentiment,
            'severity' => $severity,
            'summary' => 'Resumen (mock): el usuario comenta su experiencia y deja observaciones.',
            'improvements' => [
                'Mejorar mensajes de validación y errores.',
                'Revisar UX en formularios (espaciados / feedback).',
            ],
        ];
    }
}