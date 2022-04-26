$(document).ready(function() {
    var counter = 1;

    $("#addrow").on("click", function() {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td  style="border-top: none;"><input type="text" class="form-control" name="nomePlus' + counter + '"/></td><td  style="border-top: none;"><input type="date" class="form-control" name="dataNascimento' + counter + '"/></td>';

        cols += '<td  colspan="1" style="text-align: left; border-top: none;"><input type="button" class="ibtnDel btn btn-sm btn-danger" value="Excluir"></td>';
        newRow.append(cols);
        $("table.table-borderless").append(newRow);
        counter++;
    });

    $("table.table-borderless").on("click", ".ibtnDel", function(event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

});

function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.table-borderless").find('input[name^="price"]').each(function() {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}