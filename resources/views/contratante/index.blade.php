@extends('layouts.app-vitu')

@section('content')

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Olá {{ Auth::user()->name }}</h1>
        </div>

        <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Você está logado como <u>Contratante</u></th>
                            </tr>
                        </thead>
                    </table>
                </div> 
        </div>
@endsection
