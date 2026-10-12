<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Codly · Requirement workspace</title>@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body><header><a href="{{ route('home') }}">CODLY · India Private Limited</a><span>Requirement & project analysis</span>@auth<a href="{{ route('projects.index') }}">Projects</a><form method="post" action="{{ route('logout') }}">@csrf<button>Sign out</button></form>@else<a href="{{ route('login') }}">Sign in</a>@endauth</header>
<main><aside>Local deterministic demo · No live AI · All plans, designs, estimates and proposals require human validation.</aside>
@if($errors->any())<div role="alert"><strong>Please correct the submission.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')</main></body></html>