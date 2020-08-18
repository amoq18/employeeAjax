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
        <table width="100%" border="1" id="table-data">
            <tbody id="tableBody">
                <tr>
                    <td>Nom produit</td>
                    <td>Description</td>
                    <td>Prix</td>
                    <td>Quantité</td>
                    <td>Montant</td>
                    <td>
                        <button id="add">Ajouter</button>
                        <!-- <input class="Sup" type="submit" value="Supprimer" /> -->
                    </td>
                </tr>
                <tr class='input-form'>
                    <td>
                        {{-- <select class='selUser' id="nom_0" name="nom_0" style='width: 200px;'>
                            <option value='0'>-- Selectionner produit --</option>
                        </select> --}}
                        <select class='selUser' id="nom_0" name="nom_0" style='width: 200px;'>
                            <option value='0'>-- Selectionner produit --</option>
                        </select>
                    </td>
                    <td><input id="description_0" name="description_0" type="text" /></td>
                    <td><input id="prix_0" name="prix_0" type="number" /></td>
                    <td><input id="quantite_0" name="quantite_0" type="number" /></td>
                    <td><input id="montant_0" name="montant_0" type="number" /></td>
                    <td><input type="button" class="addButton" value="Add" /></td>
                    <td><input type="button" onClick="$(this).parent().parent().remove();" value="supprimer"></td>
                </tr>
            </tbody>
        </table>
    </form>

    <!-- Script -->
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $(function(){
        $("#table-data").on('click', 'input.addButton', function() {
            var $tr = $(this).closest('tr');
            var allTrs = $tr.closest('table').find('tr');
            var lastTr = allTrs[allTrs.length-1];
            var $clone = $(lastTr).clone();

            $clone.find('td').each(function(){
                var el = $(this).find(':first-child');
                var id = el.attr('id') || null;
                if(id) {
                    var i = id.substr(id.length-1);
                    var prefix = id.substr(0, (id.length-1));
                    el.attr('id', prefix+(+i+1));
                    el.attr('name', prefix+(+i+1));

                    // Ajout des valeurs dsn les inputs
                    $("select#nom_"+i).change(function(){
                        var selectedUser = $(this).children("option:selected").val();
                        $('#description_'+i).val(selectedUser);
                    });

                    // $("#table-data").on('change', 'select', function(){
                    //     var val = $(this).val();
                    //     // $(this).closest('tr').find('input:text').val(val);
                    //     $('#description_'+i).val(selectedUser);
                    // });
                }
            });
            $clone.find('input:text').val('');
            $tr.closest('table').append($clone);
        });
            // Gestion de gestion du select2
            $(document).ready(function(){

                $.ajax({
					url: "{{ route('getProducts') }}",
					method: 'GET'
				})
				.done(function(data){
                    console.log(data);
					data.forEach(function(prod){
						$(".selUser").append('<option value="'+ prod +'">'+ prod +'</option>')
					})
					
				})
				.fail(function(error){
					console.log(error)
				})

        });
    });
    </script>
  </body>
</html>
