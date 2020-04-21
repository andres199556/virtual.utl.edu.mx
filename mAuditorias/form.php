<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form name="formulario1" id="form" method="post" action="http://suriutl.com/abmcalif/validacion.php">
        <div>
            <h2>Login Plan 2009</h2>
            <pre>   Usuarios:
  <select name="usuarios" style="width:14em;"><option value="8953"></option>
 </select>
   Contraseña:
  <input type="password" name="password" size="25">
   Carreras:
  <select name="carreras" style="width:14em;"><option value="63"></option>
 </select>

  <input type="submit" value="Entrar" > <input type="Reset" value="Borrar">
    <font color="red">  - </font>
 Inicio : <font color="red"></font>
 Fin : <font color="red"></font>

  <font color="green">Navegadores Compatibles:</font>
  1.- Internet Explorer
  2.- Google Chrome
  3.- Opera
  4.- Safari
</pre>
        </div>
    </form>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script>
    $("#forsm").submit(function(e) {
        $.ajax({
            url: "http://suriutl.com/abmcalif/validacion.php",
            type: "POST",
            headers: {"Access-Control-Allow-Origin": "*"},
            dataType: "html",
            xhrFields: {
       withCredentials: true
    },
    crossDomain: true,
            data: $(this).serialize()
        }).done(function(exito) {
            alert(exito);
        }).fail(function(error) {
            alert(error);
        });
        e.preventDefault();
        return false;
    })
    </script>
</body>

</html>