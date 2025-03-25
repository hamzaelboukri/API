<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompetenceController extends Controller
{
    /**
     * Afficher une liste des compétences.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $competences = Competence::all();
        
        return response()->json([
            'success' => true,
            'data' => $competences,
        ]);
    }

    /**
     * Enregistrer une nouvelle compétence.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
        ]);

        // Générer un slug unique
        $validated['slug'] = Str::slug($validated['name']);
        
        $competence = Competence::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Compétence créée avec succès',
            'data' => $competence,
        ], 201);
    }

    /**
     * Afficher une compétence spécifique.
     *
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Competence $competence)
    {
        return response()->json([
            'success' => true,
            'data' => $competence,
        ]);
    }

    /**
     * Mettre à jour une compétence spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Competence $competence)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
        ]);

        // Mettre à jour le slug si le nom a changé
        if (isset($validated['name']) && $validated['name'] !== $competence->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $competence->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Compétence mise à jour avec succès',
            'data' => $competence,
        ]);
    }

    /**
     * Supprimer une compétence spécifique.
     *
     * @param  \App\Models\Competence  $competence
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Competence $competence)
    {
        $competence->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Compétence supprimée avec succès',
        ]);
    }
}