<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

✍🏻 Descrição
<hr>
Aplicação desenvolvida utilizando multi login, são 3 perfis direntes acessos. Login usando CPF e Senha, e a rota direciona para páginas diferentes, parametrizado para: Administrador, Contratante, Financeiro.
<br>
<br>

🧪 Tecnologias
<hr>
<ul>
    <li>Laravel: 8.61</li>
    <li>PHP: 7.3</li>
    <li>MySql</li>
    <li>Fortify</li>
    <li>JetStream</li>
    <li>LiveWire</li>
    <li>BootStrap</li>
</ul>
 🚀 Como executar
<hr>

```
- composer install
- npm install
- npm run dev
- mude .env.example para .env na pasta raiz.
- Abra o arquivo .env e altere o nome do banco de dados (DB_DATABASE) para o que tiver, o nome de usuário (DB_USERNAME) e a senha (DB_PASSWORD) correspondem à sua configuração.
- Por padrão, o nome de usuário é root e você pode deixar o campo da senha em branco. (Isto é para Xampp)
- Por padrão, o nome de usuário é root e a senha também é root. (Isto é para Xampp)
- Execute php artisan key:generate
- Execute php artisan migrate
- Execute php artisan serve
- Irá abrir no localhost:8000
```

💻 Passo a passo de como fazer

<details><summary><b>1 - Criando as migrations</b></summary>

- 1.1 - Cria uma tabela migration perfil (role)
- 1.2 - Alterar a migration Users inserindo a coluna de perfil_id (role) - foreign key
</details>

<details><summary><b>2 - Alterando o formulário de cadastro</b></summary>

- 2.1 - Em App\Fortify\CreateNewUser, acrescentar os campos a mais do registro
```         
return User::create([
            'name' => $input['name'],
            'cpf' => $input['cpf'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $input['role_id'],
        ]); 
```
- 2.2 - Inserindo o perfil do formulário de cadastro, em Resources\views\auth\register.blade.php
``` 
            <div class="mt-4">
                <x-jet-label for="role_id" value="{{ __('Perfil') }}" />
                <select name="role_id" id="role_id" x-model="role_id" class="block mt-1 w-full border-gray-300">
                    <option value="">Selecione...</option>
                    <option value="1">Administrador</option>
                    <option value="2">Contratante</option>
                    <option value="3">Financeiro</option>
                </select>
            </div>    
```
</details>

<details><summary><b>3 - Criando as controllers</b></summary>

- 3.1 - Cria as controllers em cada pasta de perfil (eu acho mais organizado)
``` 
php artisan make:controller Admin/HomeController
php artisan make:controller Contratante/HomeController
php artisan make:controller Financeiro/HomeController
```
- 3.2 - E insira o a function index() abrindo cada view respectiva de cada controller
```
    public function index()
    {
        return view('administrador.index');
    }
```
</details>

<details><summary><b>4 - Criando e configurando a middleware</b></summary>

- 4.1 - Crie a middleware com o nome CheckRole
```
php artisan make:middleware CheckRole
``` 
- 4.2 - Abra ela em: App\Http\Middleware\CheckRole.php e coloque o código abaixo:
```
    public function handle(Request $request, Closure $next, string $role)
    {
            if ($role == 'admin' && auth()->user()->role_id != 1) {
                // abort(403);
                Auth::logout();
                return redirect()->route('login')
                ->withInput()
                ->with('erro','Página acessada somente por administrador');
            }

            if ($role == 'contratante' && auth()->user()->role_id != 2) {
                // abort(403);
                Auth::logout();
                return redirect()->route('login')
                ->withInput()
                ->with('erro','Página acessada somente por contratante');
            }

            if ($role == 'financeiro' && auth()->user()->role_id != 3) {
                // abort(403);
                Auth::logout();
                return redirect()->route('login')
                ->withInput()
                ->with('erro','Página acessada somente pelo financeiro');
            }

            return $next($request);
    }
```    
- 4.3 - Adicionar a middleware em Kernel.php App\Http\Kernel.php, embaixo de protected $routeMiddleware 
    ```  
    'role' => \App\Http\Middleware\CheckRole::class,
    ``` 
</details>

<details><summary><b>5 - Configurando as permissões das rotas no provider</b></summary>

- 5.1 - Em App\Providers\FortifyServiceProvide, dentro do public function register(){}
```
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;

   
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
               
                if (auth()->user()->role_id == 1) {
                    return redirect()->route('admin.home');
                }else if (auth()->user()->role_id == 2) {
                    return redirect()->route('contratante.home');
                }if (auth()->user()->role_id == 3) {
                    return redirect()->route('financeiro.home');
                } else {
                        Auth::logout();
                        return redirect()->route('login')
                        ->withInput()
                        ->with('erro','Sem permissão para acessar');
                }

               
            }
        });
```
- 5.2 - Configurando redirecionamento quando fizer logout, dentro do public function register(){}
 ```
 use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/volte-sempre');
            }
        });

 ```
</details>

<details><summary><b>6 - Configurando a rota</b></summary>

- 6.1 - Configurando a rota-> routes\web.php
```
Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => 'role:contratante'], function() {
        Route::get('/contratante/home', 'Contratante\HomeController@index')->name('contratante.home');
    });
    
    Route::group(['middleware' => 'role:admin'], function() {
        Route::get('/admin/home', 'Admin\HomeController@index')->name('admin.home');
    });
    Route::group(['middleware' => 'role:financeiro'], function() {
        Route::get('/financeiro/home', 'Financeiro\HomeController@index')->name('financeiro.home');
    });
});
```
 
</details>

<details><summary><b>7 - Criando as views</b></summary>

- 7.1 - Criar as views de acordo como colocou em cada controller, neste exemplo: resources\views\admin\index.blade.php
```
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
                                <th>Você está logado como <u>Administrador</u></th>
                            </tr>
                        </thead>
                    </table>
                </div> 
        </div>
@endsection
```

- 7.2 - Criar as views de acordo como colocou em cada controller, neste exemplo: resources\views\contratante\index.blade.php
```
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
```

- 7.3 - Criar as views de acordo como colocou em cada controller, neste exemplo: resources\views\financeiro\index.blade.php
```
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
                                <th>Você está logado como <u>Financeiro</u></th>
                            </tr>
                        </thead>
                    </table>
                </div> 
        </div>
@endsection
```
</details>

<hr>
Opcionais
<details><summary><b>8 - Alterando login para cpf</b></summary>

- 8.1 - Em: App\providers\AuthServiceProvide.php, exemplo de alterando o campo de login para CPF
``` 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

 public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('cpf', $request->email)->first();
    
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        $this->registerPolicies();

        //
    }
```
- 8.2 - E insira o a function index() abrindo cada view respectiva de cada controller
```
    public function index()
    {
        return view('administrador.index');
    }
```
</details>


<details><summary><b>9 - Liberar usar foto no perfil</b></summary>

- 9.1 - Em: config\jetstream.php
``` 
'features' => [
        Features::termsAndPrivacyPolicy(),
        Features::profilePhotos(),
        Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
```
- 9.2 - Liberando um link para foto
```
    php artisan storage:link
```
</details>
<details><summary><b>10 - Alterar padrão de senha</b></summary>

- 10.1 - Arquivo responsável pelo password /Vendor/laravel/fortify/src/Rules/Password.php

</details>
<details><summary><b>11 - Liberar views Livewire na pasta de resources</b></summary>

- 11.1 - Digite o comando no terminal
```
 php artisan vendor:publish --tag=jetstream-views
 ```

</details>



   
