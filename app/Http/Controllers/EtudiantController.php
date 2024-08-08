<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Models\Etudiant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;



class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Etudiants = Etudiant::all();
        return response()->json([
            'status'=>true,
            'message'=>"etudiant afficher avec succé",
            "data"=>$Etudiants
        ],200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateEtudiant = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|numeric|digits:10', 
            'email' => 'required|email|unique:etudiants,email',
            'date_de_naissance' => 'required|date',
            'photo' => 'required|string', 
            'matricule' => 'required|string|unique:etudiants,matricule',
        ]);
    
        if ($validateEtudiant->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation error",
                "data" => $validateEtudiant->errors()
            ], 400);
        }
    
        // Gestion des fichiers Base64
        $photoName = null;
        if ($request->has('photo')) {
            $photoData = $request->photo;
            $photoData = str_replace('data:image/jpeg;base64,', '', $photoData);
            $photoData = base64_decode($photoData);
            $photoName = time() . '.jpg'; 
            Storage::disk('public')->put('photos/' . $photoName, $photoData);
        }
    
        // Préparation des données d'entrée
        $inputData = $request->only([
            'prenom',
            'nom',
            'adresse',
            'telephone',
            'email',
            'date_de_naissance',
            'matricule'
        ]);
        $inputData['photo'] = $photoName; // Inclure le nom de fichier de la photo
    
        // Création d'un nouvel étudiant
        $etudiant = Etudiant::create($inputData);
    
        return response()->json([
            "status" => true,
            "message" => "Étudiant ajouté avec succès",
            "data" => $etudiant
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validation des données d'entrée
        $validateEtudiant = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|numeric|digits:10', 
            'email' => [
                'required',
                'email',
                Rule::unique('etudiants', 'email')->ignore($request->id),
            ],
            'date_de_naissance' => 'required|date',
            'photo' => 'required|string',
            'matricule' => [
                'required',
                'string',
                Rule::unique('etudiants', 'matricule')->ignore($request->id), 
            ],
        ]);
    
        // Retourner les erreurs de validation si elles existent
        if ($validateEtudiant->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation error",
                "data" => $validateEtudiant->errors()
            ], 400);
        }
    
        // Trouver l'étudiant par ID et mettre à jour les informations
        $etudiant = Etudiant::find($request->id);
    
        if (!$etudiant) {
            return response()->json([
                "status" => false,
                "message" => "Etudiant non trouvé",
            ], 404);
        }
    
        $etudiant->prenom = $request->prenom;
        $etudiant->nom = $request->nom;
        $etudiant->adresse = $request->adresse;
        $etudiant->telephone = $request->telephone;
        $etudiant->email = $request->email;
        $etudiant->date_de_naissance = $request->date_de_naissance;
        $etudiant->photo = $request->photo;
        $etudiant->matricule = $request->matricule;
    
        $etudiant->save();
    
        return response()->json([
            "status" => true,
            "message" => "Étudiant mis à jour avec succès",
            "data" => $etudiant
        ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */public function destroy($id)
{
    // Validation de l'ID
    $validateEtudiant = Validator::make(['id' => $id], [
        "id" => 'required|exists:etudiants,id',
    ]);

    // Si la validation échoue, retourner une réponse d'erreur
    if ($validateEtudiant->fails()) {
        return response()->json([
            'status' => false,
            'message' => "Validation error",
            'data' => $validateEtudiant->errors()
        ], 422);
    }

    // Trouver l'étudiant par ID et le supprimer
    $etudiant = Etudiant::find($id);
    
    if ($etudiant) {
        $etudiant->delete();
        return response()->json([
            'status' => true,
            'message' => 'Etudiant supprimé avec succès'
        ], 200);
    }

    return response()->json([
        'status' => false,
        'message' => 'Etudiant non trouvé'
    ], 404);
}

    
}
