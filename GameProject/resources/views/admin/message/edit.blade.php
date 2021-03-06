@extends('layouts.admin')
@section('content')


<h2> Modifier un produit : {{$unMessage->nom}} </h2>

    {!! Form::open(['method'=>'put', 'route' => ['message.update', $unMessage->id],'class' => 'form-horizontal']) !!}
<div class="well">
           <div class="form-group">
      {!! Form::label('titre', 'Titre :',['class' => 'col-lg-2 control-label'])!!}
      <div class="col-lg-10">
          {!! Form::text('titre',$unMessage->titre, ['placeholder' => 'titre','class' => 'form-control'])!!}
      </div>
      
      
      @if ($errors->has('titre'))               
      <div class="alert alert-danger">  
          <!--afficher les erreurs une par une-->
          @foreach ($errors->get('titre') as $message)
          <ul>
               
          <li> {{ $message }}</li>
                
          </ul>
          @endforeach
          
      </div>
      @endif
</div>

<div class="form-group">
    
      {!! Form::label('description','Description',['class' => 'col-lg-2 control-label'])!!}
      <div class="col-lg-10">
      {!! Form::textarea('description',$unMessage->description,['placeholder' => 'description','class' => 'form-control', 'rows' => 3])!!}
      </div>
       @if ($errors->has('description'))
       <div class="alert alert-danger">
            @foreach ($errors->get('description') as $message)
           <ul>
               
                <li>{{ $message }}</li>
           </ul>
            @endforeach
       </div>
@endif
</div>

<button type="submit" class=" btn btn-primary center-block">Créer</button>
</div>
{!! Form::close() !!}
@stop
