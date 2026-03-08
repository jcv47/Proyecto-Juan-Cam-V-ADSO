<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Profile;
use App\Models\Survey;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@sondar.com'],
            [
                'name' => 'Admin Sondar',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'ubicacion_usuario' => 'Cali, Colombia',
                'birthdate' => '2000-01-01',
            ]
        );

        // 2) Cliente
        $cliente = User::updateOrCreate(
            ['email' => 'cliente@sondar.com'],
            [
                'name' => 'Cliente Demo',
                'password' => Hash::make('12345678'),
                'role' => 'cliente',
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $cliente->id],
            [
                'ubicacion_usuario' => 'Bogotá, Colombia',
                'birthdate' => '2002-05-10',
            ]
        );

        // 3) Encuesta fija (Plantilla)
        $survey = Survey::updateOrCreate(
            ['titulo' => 'Reseña rápida de experiencia'],
            [
                'descripcion' => 'Cuéntanos tu experiencia. Esto nos ayuda a mejorar.',
                'estado' => 1,
                'layout' => 'plantilla',
                'created_by' => $admin->id,
            ]
        );

        $questions = [
            ['tipo' => 'general', 'contenido' => 'Motivo del comentario'],
            ['tipo' => 'general', 'contenido' => 'Satisfacción general'],
            ['tipo' => 'general', 'contenido' => 'Comentarios'],
            ['tipo' => 'general', 'contenido' => 'Solicitud de funcionalidad (opcional)'],
        ];
        // 3) Encuesta demo (activa) creada por admin
        $survey = Survey::updateOrCreate(
            ['titulo' => 'Encuesta de satisfacción (Demo)'],
            [
                'descripcion' => 'Queremos saber tu opinión sobre nuestros productos y servicios.',
                'estado' => 1,
                'created_by' => $admin->id,
                'layout' => 'normal',
            ]
        );

        // 4) Preguntas demo (ligadas a la encuesta)
        $questions = [
            ['tipo' => 'servicio', 'contenido' => '¿Cómo calificarías nuestro servicio en general?'],
            ['tipo' => 'producto', 'contenido' => '¿Qué te pareció la calidad del producto que recibiste?'],
            ['tipo' => 'servicio', 'contenido' => '¿Qué mejorarías de tu experiencia con nosotros?'],
        ];

        foreach ($questions as $q) {
            Question::updateOrCreate(
                [
                    'survey_id' => $survey->id,
                    'contenido' => $q['contenido'],
                ],
                [
                    'tipo' => $q['tipo'],
                ]
            );
        }
    }
}
