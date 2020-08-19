<!DOCTYPE html>
<html>

<head>
    <title>Loading data remotely in Select2 – Laravel</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">

    <!-- Script -->
    <script src="{{ asset('jquery-2.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>

</head>

<body>
    <h2>Offer</h2>
    <button type="button" class="addRow">Add</button>
    <form>
        <table id="tab1">
            <tr>
                <th>Nom produit</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Montant</th>
            </tr>
            <tr class="ligneTab">
                <td>
                    {{-- <select class="select2" name="selectPdts" style="width: 200px;"">
                        <option value='0'>-- Selectionner produit --</option>
                    </select> --}}
                    <select class="select2" name="det_brg" style="width:100%;"></select>
                </td>
                <td><input name="desc" class="" value="" /></td>
                <td><input name="prix" type="number" class="prix amount" value="" /></td>
                <td><input name="qte" type="number" class="qte amount" value="" /></td>
                <td><input name="total" min="0" value="0" type="number" class="total" readonly="readonly" /></td>
            </tr>
        </table>

        <br />

        <table id="tab2">
            <tr>
                <td>Nette =<br></td>
                <td><input id="nette" readonly="readonly" name="nette" type="text" value=""></td>
            </tr>
            <tr>
                <td>impôt 19% =<br></td>
                <td><input id="impot" readonly="readonly" name="impot" type="text" value=""></td>
            </tr>
            <tr>
                <td>Brut =<br></td>
                <td><input id="brut" readonly="readonly" name="brut" type="text" value=""></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>

    <!-- Script -->
    <script type="text/javascript">

        $(document).ready(function() {
            // Gestion de gestion du select2
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function() {
                $(".select2").select2({
                    ajax: {
                        url: "{{ route('getProducts') }}",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
            });

            // function for adding a new row
            var r = 1;
            $('.addRow').click(function() {
                r++;
                $('#tab1').append(
                    '<tr id="row' + r + '" class="ligneTab">\
                        <td>\
                            <select class="select2" name="det_brg" style="width:100%;"></select>\
                        </td>\
                        <td><input name="desc" class="" value="" /></td>\
                        <td><input name="prix'+r+'" type="number" class="prix amount" value="" /></td>\
                        <td><input name="qte'+r+'" type="number" class="qte amount" value="" /></td>\
                        <td><input name="total'+r+'" min="0" value="0" type="number" class="total" readonly="readonly" /></td>\
                        <td><button type="button" name="remove" id="' + r + '" class="btn_remove">X</button></td>\
                    </tr>'
                );
                // $().val(0)
                // $('.prix').val(0)
                // $('.total').val(0)
                var newSelect=$("#tab1").find(".select2").last();
                initializeSelect2(newSelect);
            });

            // remove row when X is clicked
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                // calculate everything
                $(".amount", calcAll);
            });

            // calculate everything
            $(document).on("keyup", ".amount", calcAll);

            // function for calculating everything
            function calcAll() {
                // calculate total for one row
                $(".ligneTab").each(function() {
                    var qte = 0;
                    var prix = 0;
                    var total = 0;
                    if (!isNaN(parseInt($(this).find(".qte").val()))) {
                        qte = parseInt($(this).find(".qte").val());
                    }
                    if (!isNaN(parseInt($(this).find(".prix").val()))) {
                        prix = parseInt($(this).find(".prix").val());
                    }
                    total = qte * prix;
                    $(this).find(".total").val(total);
                });

                // sum all totals
                var sum = 0;
                $(".total").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });
                // show values in nette, impot, brut fields
                $("#nette").val(sum.toFixed(2));
                $("#impot").val(sum.toFixed(2) * 0.19);
                $("#brut").val(parseFloat(sum.toFixed(2)) + parseFloat(($("#impot").val())));
            }

            // Charger données avec Select2
            function initializeSelect2(selectElementObj) {
                selectElementObj.select2({
                    width: "80%",
                    tags: true,
                    language: "id",
                    ajax: {
                        url: "{{ route('getProducts') }}",
                        dataType: "json",
                        type: "POST",
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            }
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.text
                                    }
                                })
                            };
                        },
                        cache: false
                    },
                    minimumInputLength: 3,
                    dropdownParent: $("#form-data")
                });
            };

            $(".select2").each(function() {
                initializeSelect2($(this));
            });

            // Chargement des infos du select dns les inputs
            $( ".select2" ).change(function(){
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
                    $(this).closest('td').next().next().next().children().val(data.quantite)
                    $(this).closest('td').next().next().next().next().children().val(data.montant)

                }).fail(function(err){
                    console.log(err)
                })

            })
        });
    </script>
</body>

</html>
