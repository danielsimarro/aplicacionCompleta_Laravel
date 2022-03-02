<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Coches</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/jumbotron.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('favFreno.png') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('css')
  </head>
  <body>
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
          @section('header')
          <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <div class="icono"></div>
            <span class="fs-4">Daniel Simarro Reigada</span>
          </a>
          @show
        </header>
        <div class="content">
             @yield('content')
        </div>
        <footer class="pt-3 mt-4 text-muted border-top">
          @include('base.footer')
        </footer>
      </div>
    </main>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('js')
  </body>
</html>

<style>
.form-group{
  margin-top:10px;
}

#enviar{
  
  margin-top:30px;
  margin-right:50px;
  width:20%;
  
}

#volver{
  margin-top:30px;
  width:10%;
}

.table{
  margin:20px 0;
}

#enviarimg{
  margin-top:30px;
  margin-right:100%;
  width:20%;
  clear:both;
}

.contIMG{
  width:100%;
  height:100%;
  
  display:flex;
  align-items:center
}
img{
  max-width:100%;
  min-width:100px;
  margin:50px 0;

}

td > img {
  width:100px;
  height:60px;
}

.icono{
  width:40px;
  height:40px;
  margin-right:1%;
  background: url({{ url('freno.png') }}) no-repeat center center;
  background-size: cover;
}


</style>