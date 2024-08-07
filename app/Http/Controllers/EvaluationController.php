<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        try {
            $evaluation = Evaluation::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Évaluation affichée avec succès',
                'data' => $evaluation
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Évaluation non trouvée',
            ], 404);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateEvaluation = Validator::make($request->all(), [
            'date_evaluation' => 'required|date|before_or_equal:today',
            'note' => 'required|integer|between:0,20',
            'etudiant_id' => 'required|exists:etudiants,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);
    
        if ($validateEvaluation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'error' => $validateEvaluation->errors(),
            ], 400);
        }
    
        $inputData = $request->only([
            'date_evaluation',
            'note',
            'etudiant_id',
            'matiere_id',
        ]);
    
    
        try {
            $evaluation = Evaluation::create($inputData);
    
            return response()->json([
                'status' => true,
                'message' => 'Évaluation ajoutée avec succès',
                'data' => $evaluation,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de l\'ajout de l\'évaluation',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateEvaluation = Validator::make($request->all(), [
            'date_evaluation' => 'required|date|before_or_equal:today',
            'note' => 'required|integer|between:0,20',
            'etudiant_id' => 'required|exists:etudiants,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);
        // Retourner les erreurs de validation si elles existent
        if ($validateEvaluation->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validation error',
            ],404);

        }
          // Trouver l'evaluation par ID et mettre à jour les informations
        $evaluation= Evaluation::findOrFail($request->id);
        if(! $evaluation) {
            return response()->json([
                'status'=> false,
                'message'=> 'evaluation non trouvé',
            ],404);
        }
        $evaluation->date_evaluation= $request->date_evaluation;
        $evaluation->note= $request->note;
        $evaluation->etudiant_id= $request->etudiant_id;
        $evaluation->matiere_id= $request->matiere_id;
        $evaluation->save();
        return response()->json([
            'status'=> true,
            'message'=> 'l\'evaluation mis à jour avec succés',
            'data'=>$evaluation
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validateEvaluation=Validator::make(['id'=> $id],[
            'id'=> 'required|exists:evaluations,id',
        ]);
        if ($validateEvaluation->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'Validation error',
                'data'=> $validateEvaluation->errors(),
            ], 422);
    }
    $evaluation=Evaluation::find($id);
    if ($evaluation) {
        $evaluation->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'evaluation supprimer avec succé',
        ],200);
    }
    return response()->json([
        'status'=> false,
        'message'=> 'evaluation non trouvé'
    ],404);
}
}