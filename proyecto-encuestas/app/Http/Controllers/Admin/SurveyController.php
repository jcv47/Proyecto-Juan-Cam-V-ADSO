<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Mail\SurveyActivatedMail;
use Illuminate\Support\Facades\Mail;
class SurveyController extends Controller
{
    public function create()
    {
        return view('admin.surveys.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'titulo' => ['required', 'string', 'max:255'],
        'descripcion' => ['required', 'string', 'max:2000'],
        'estado' => ['required', 'in:0,1'],
        'questions' => ['required', 'array', 'min:1'],
        'questions.*.tipo' => ['required', 'in:producto,servicio,general'],
        'questions.*.contenido' => ['required', 'string', 'max:255'],
    ]);

    $survey = DB::transaction(function () use ($data) {

        $survey = Survey::create([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'estado' => (int) $data['estado'],
            'layout' => 'normal',
            'created_by' => auth()->id(),
        ]);

        foreach ($data['questions'] as $q) {
            Question::create([
                'survey_id' => $survey->id,
                'tipo' => $q['tipo'],
                'contenido' => $q['contenido'],
            ]);
        }

        return $survey;
    });

    // Si la encuesta quedó activa
    if ($survey->estado == 1) {

        $clientes = User::where('role', 'cliente')
            ->whereNotNull('email_verified_at')
            ->get();

        foreach ($clientes as $cliente) {

            Mail::to($cliente->email)
                ->send(new SurveyActivatedMail($survey));
        }
    }

    return redirect()->route('admin.surveys.create')
        ->with('success', 'Encuesta creada correctamente.');
}
}