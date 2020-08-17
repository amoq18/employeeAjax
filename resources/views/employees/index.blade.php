<!DOCTYPE html>
<html>
  <head>
    <title>Loading data remotely in Select2 – Laravel</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}">

    <!-- Script -->
    <script src="{{asset('jquery-2.1.3.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript"></script>

  </head>
  <body>
    <form id="form" method="get" >
        <table width="100%" border="1" id="t" >
            <tbody id="tableBody">
                <tr>
                    <td>Description</td>
                    <td>Prix</td>
                    <td>Quantité</td>
                    <td>
                        <button id="add">Ajouter</button>
                        <!-- <input class="Sup" type="submit" value="Supprimer" /> -->
                    </td>
                </tr>
                <tr id="tableRow">
                    <td>
                        <select class='selUser' style='width: 200px;'>
                            <option value='0'>-- Select user --</option>
                        </select>
                    </td>
                    <td><input id="p" type="text" /></td>
                    <td><input id="q" type="text" /></td>
                    <td><input type="button" onClick="$(this).parent().parent().remove();" value="supprimer"></td>
                </tr>
                {{-- <tr id="tableRow">
                    <td><input id="d" type="text" /></td>
                    <td><input id="p" type="text" /></td>
                    <td><input id="q" type="text" /></td>
                    <td><input class="Sup" type="submit" value="Supprimer"/></td>
                </tr> --}}
            </tbody>
        </table>
    </form>
    <!-- For defining autocomplete -->

    <!-- Script -->
    <script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( ".selUser" ).select2({
        ajax: {
          url: "{{route('employees.getEmployees')}}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });

    });
    </script>

<script>
    $(function () {
        // ajoute ligne dans le tableau
        $("#add").click(function () {
            var1 = 'onClick="$(this).parent().parent().remove()"'
            var2 = "<option value='0'>-- Select user --</option>"
            console.log(var2)
            $('#tableBody').append(
                "<tr id='tableRow'>"+
                    "<td>"+
                        "<select class='selUser' style='width: 200px;'>"+var2+"</select>"+
                    "</td>"+
                    "<td><input id='p' type='text' /></td>"+
                    "<td><input id='q' type='text' /></td>"+
                    "<td><input value='delete' type='button'" +var1+ " ></td>"+
                "</tr>"
            );

        });

        $("#form").submit(function(){
            return false;
        });
    });
</script>
  </body>
</html>
