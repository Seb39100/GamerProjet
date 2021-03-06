<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sujet;
use Validator;
use App\Models\Jeu;
use App\Models\Poste;
use Illuminate\Support\Facades\Auth;


class SujetController extends Controller
{
    
    public function __construct()
    {
       
      $this->middleware('auth', ['except' => ['index', 'show', 'sujetsUnJeu']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lesSujets = Jeu::All(); //faire foreach sur les jeux aulieu des sujet, et faire dans le code que si le jeu a un sujet alors afficher le jeu.
        
        //$lesSujets=Sujet::paginate(20);
        return view('front/sujet/index', compact('lesSujets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lesJeux = Jeu::orderBy('nom')->pluck('nom', 'id');
        return view('front/sujet/create', compact('lesJeux'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|max:255',
              'jeu' => 'required',
            'desc' => 'required|max:65535|min:10',
           
        ]);

        if ($validator->fails()) {
            return redirect('front/sujet/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else
        {
            
         $unSujet= new Sujet();
         $unSujet->titre=$request->get('titre'); 
         $unSujet->jeu_id = $request->get('jeu'); 
         $unSujet->save();         
         $unPoste = New Poste();
         $unPoste->description = $request->get('desc');
         $unPoste->sujet_id = $unSujet->id;
         $unPoste->user_id = Auth::id();   
         $unPoste->signale=false;
         $unPoste->save();
         $request->session()->flash('success', 'Sujet crée.');
        return redirect(route('sujet.show', $unSujet->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unSujet=Sujet::find($id);
        $lesPostes = Poste::orderBy('id')->where('sujet_id', $id)->paginate(10);
        return view('front/sujet/show', compact ('unSujet', 'lesPostes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                $unSujet=Sujet::find($id);
        return view('admin/sujet/edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
                 $unSujet=Sujet::find($id);
         $unSujet->titre=$request->get('titre');
         $unSujet->save();
         $request->session()->flash('success', 'Sujet modifié !');
         return redirect(route('sujet.index'));  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                $unSujet=Sujet::find($id);
        $unSujet->save();
        $request->session()->flash('success', 'Sujet supprimé !');
        return redirect(route('sujet.index'));
    }
    
    public function fermer($id)
    {
        $unSujet = Sujet::find($id);
        $unSujet->ferme = true;
        
        $unSujet->update();
        return redirect (route('sujet.sujetsUnJeu', $unSujet->jeu->id));
    }
    
     public function ouvrir($id)
    {
        $unSujet = Sujet::find($id);
        $unSujet->ferme = false;
        
        $unSujet->update();
        return redirect (route('sujet.sujetsUnJeu', $unSujet->jeu->id));
    }
    
    public function sujetsUnJeu($idJeu)
    {
        $jeu = Jeu::find($idJeu);
        $lesSujets = Sujet::where('jeu_id', $idJeu)->paginate(40); 
//        $lesSujets = Sujet::where('jeu_id', $idJeu)->with(['poste' => function ($query) {
//    $query->orderBy('id', 'desc');
//}])->paginate(20);
//
//$lesSujets = Sujet::where('jeu_id', $idJeu)
//->with(['poste'])->get()
//->sortByDesc('poste.id');
         // dd($lesSujets);   
        
        return view('front/sujet/sujetparjeu', compact('lesSujets', 'jeu'));
                
    }
}
