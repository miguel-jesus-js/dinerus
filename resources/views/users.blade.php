<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dinerus</title>
        <link rel="stylesheet" href="{{asset('css/tabler.min.css')}}">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="">
        <div class="container">
            <br>
             <center>
                <h1>USUARIOS</h1>
             </center>
             <br><br>
             <div class="table-responsive">
                <table class="table table-vcenter table-mobile-md card-table">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>N° de cuenta</th>
                      <th>Banco</th>
                      <th>Turno</th>
                      <th>Referencia</th>
                      <th>Correo</th>
                      <th>Pagado</th>
                      <th colspan="2">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->full_name}}</td>
                            <td>{{$user->account_number}}</td>
                            <td>{{$user->bank}}</td>
                            <td>{{$user->shift}}</td>
                            <td>{{$user->reference}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->paid}}</td>
                            <td>
                                <button class="btn">
                                    Descargar comprobante
                                </button>
                                <button class="btn">
                                    Marcar como pagado
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    
                   
                  </tbody>
                </table>
              </div>
        </div>
        <script src="{{asset('js/tabler.min')}}"></script>
    </body>
</html>
