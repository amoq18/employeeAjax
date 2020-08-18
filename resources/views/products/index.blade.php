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
                    <td>Bouton</td>
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

        $(document).ready(function () {
            // Gestion de gestion du select2
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function(){
                $( ".selUser" ).select2({
                    ajax: {
                    url: "{{ route('getProducts') }}",
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



            $( ".selUser" ).change(function(){
                $.ajax({
                    url: "{{ route('getProduct') }}",
                    type: "post",
                    data: {
                        _token: CSRF_TOKEN,
                        product_id: $(this).val()
                    },
                    dataType: 'json',
                }).done((data) => {
                    $(this).closest('td').next().children().val(data.description)
                    $(this).closest('td').next().next().children().val(data.prix)
                    $(this).closest('td').next().next().next().children().val(1)
                    $(this).closest('td').next().next().next().next().children().val(data.prix)
                    
                }).fail(function(err){
                    console.log(err)
                })
                
            })

        });
    });
    </script>
  </body>
</html>
