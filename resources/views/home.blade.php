@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::user()->type == 2)
            <div class="panel panel-default">
                <div class="panel-heading">Usuários</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <!-- You are logged in! -->

                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Options</th>
                        </tr>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>
                                <a href="{{ route('users') . '/edit/' . $u->id }}">Editar</a>
                                <a href="{{ route('users') . '/delete/' . $u->id }}">Remover</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @else
            <div class="panel panel-default">
                <div class="panel-heading">Usuário padrão</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!

                    <a href="{{ route('users') . '/edit/' . Auth::user()->id }}">Editar seus dados</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
