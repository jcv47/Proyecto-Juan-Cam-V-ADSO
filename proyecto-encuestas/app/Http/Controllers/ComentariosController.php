<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Submission;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AiAnalyzer;
use App\Models\AiReport;

class ComentariosController extends Controller
{
    public function __construct(private AiAnalyzer $aiAnalyzer) {}
    public function index()
    {
        $user = auth()->user();

        // ADMIN: ve todas las respuestas (submissions)
        if ($user->role === 'admin') {
            $submissions = Submission::with(['survey', 'user', 'aiReport'])
                ->latest()
                ->paginate(15);

            return view('comentarios', [
                'mode' => 'admin',
                'submissions' => $submissions,
            ]);
        }

        // CLIENTE: ve encuestas activas NO respondidas + sus respuestas
        $answeredSurveyIds = Submission::where('user_id', $user->id)->pluck('survey_id');

        // Plantilla siempre visible
        $templateSurvey = Survey::where('layout', 'plantilla')
            ->where('estado', 1)
            ->first();

        // Normales activas no respondidas (únicas)
        $availableSurveys = Survey::where('estado', 1)
            ->where('layout', 'normal')
            ->whereNotIn('id', $answeredSurveyIds)
            ->latest()
            ->get();

        // Mis respuestas
        $mySubmissions = Submission::with(['survey', 'aiReport'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Separación UX (historial plantilla vs normales)
        $myTemplateSubmissions = $mySubmissions->filter(fn($s) => $s->survey?->layout === 'plantilla');
        $myNormalSubmissions = $mySubmissions->filter(fn($s) => $s->survey?->layout === 'normal');

        return view('comentarios', [
            'mode' => 'cliente',
            'templateSurvey' => $templateSurvey,
            'availableSurveys' => $availableSurveys,
            'myTemplateSubmissions' => $myTemplateSubmissions,
            'myNormalSubmissions' => $myNormalSubmissions,
        ]);
    }

    public function showSurvey(Survey $survey)
    {
        // Solo clientes deberían responder
        if (auth()->user()->role !== 'cliente') {
            abort(403, 'No autorizado');
        }

        if ($survey->estado != 1) {
            abort(404);
        }

        // No puede responder 2 veces
        // Solo bloquear si NO es plantilla (las plantillas se pueden repetir)
        if ($survey->layout !== 'plantilla') {
            $exists = Submission::where('survey_id', $survey->id)
                ->where('user_id', auth()->id())
                ->exists();

            if ($exists) {
                return redirect()->route('ui.comentarios')
                    ->with('error', 'Ya respondiste esta encuesta.');
            }
        }

        $survey->load('questions');

        if ($survey->layout === 'plantilla') {
            return view('surveys.responder_plantilla', compact('survey'));
        }

        return view('surveys.responder', compact('survey'));
    }

    public function submitSurvey(Request $request, Survey $survey)
    {
        // Seguridad: solo encuestas activas
        if ((int) $survey->estado !== 1) {
            return redirect()->route('ui.comentarios')->with('error', 'Esta encuesta no está activa.');
        }

        // Solo validar unicidad si NO es plantilla
        if ($survey->layout !== 'plantilla') {
            $yaRespondio = Submission::where('survey_id', $survey->id)
                ->where('user_id', auth()->id())
                ->exists();

            if ($yaRespondio) {
                return back()->withErrors('Ya respondiste esta encuesta.');
            }
}

        // Cargar preguntas (para reglas + guardado)
        $survey->load('questions');

        // Reglas: por defecto todas requeridas, EXCEPTO "Solicitud..." en plantilla
        $rules = [];
        foreach ($survey->questions as $q) {
            $isOptional = $survey->layout === 'plantilla'
                && $q->contenido === 'Solicitud de funcionalidad (opcional)';

            $rules["answers.{$q->id}"] = $isOptional
                ? ['nullable', 'string', 'max:2000']
                : ['required', 'string', 'max:2000'];
        }

        $validated = $request->validate($rules);

        // Guardar todo en transacción (o se guarda todo o nada)
        DB::transaction(function () use ($survey, $validated) {

            $submission = Submission::create([
                'public_id' => (string) Str::uuid(),
                'survey_id' => $survey->id,
                'user_id' => auth()->id(),
            ]);

            foreach ($validated['answers'] as $questionId => $content) {
                // Si viene null (por la opcional) no guardamos answer
                if ($content === null || trim($content) === '') {
                    continue;
                }

                Answer::create([
                    'submission_id' => $submission->id,
                    'question_id' => (int) $questionId,
                    'contenido' => $content,
                ]);
            }

            $submission->load('answers.question'); 
            
            $result = $this->aiAnalyzer->analyze($submission);

            AiReport::updateOrCreate(
                ['submission_id' => $submission->id],
                [
                    'sentiment' => $result['sentiment'],
                    'severity' => $result['severity'],
                    'summary' => $result['summary'],
                    'improvements' => $result['improvements'] ?? [],
                ]
            );
        });

        return redirect()->route('ui.comentarios')->with('success', 'Respuesta enviada correctamente.');
    }
    public function showSubmission(Submission $submission)
    {
        // admin middleware ya protege, pero igual:
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $submission->load(['user', 'survey', 'answers.question', 'aiReport']);

        // ✅ Auto-generar mock si no existe (solo para pruebas)
        if (!$submission->aiReport) {
            $this->generateMockAi($submission, true); // true = modo interno, sin redirect
            $submission->load('aiReport'); // recarga relación
        }

        return view('admin.submissions.show', compact('submission'));
    }

    public function generateMockAi(Submission $submission, bool $silent = false)
    {
        $text = $submission->answers
            ->map(fn($a) => $a->question->contenido . ": " . $a->contenido)
            ->implode("\n");

        // Mock simple: cambia según contenido
        $sentiment = str_contains(strtolower($text), 'bien') ? 'positivo' : 'neutral';
        $severity = str_contains(strtolower($text), 'bug') || str_contains(strtolower($text), 'error')
            ? 'critico'
            : 'regular';

        AiReport::updateOrCreate(
            ['submission_id' => $submission->id],
            [
                'sentiment' => $sentiment,
                'severity' => $severity,
                'summary' => 'Resumen (mock): el usuario deja observaciones sobre su experiencia.',
                'improvements' => [
                    'Revisar flujo de login cuando la contraseña es incorrecta',
                    'Mejorar mensajes de error y validación',
                ],
            ]
        );

        if ($silent)
            return null;

        return back()->with('success', 'Informe IA generado (mock)');
    }
}