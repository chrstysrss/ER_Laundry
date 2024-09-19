function addProduct(){
    $('#pna_error').text('');
    $('#ppa_error').text('');
    let isValue = true;

    let product_name = document.getElementById("product_name_add").value;
    let description = document.getElementById("description_add").value;
    let price = document.getElementById("price_add").value;
    let stock = document.getElementById("stock_add").value;

    let data= {
        product_name_add: product_name,
        description_add: description,
        price_add: price,
        stock_add: stock,
    }

    if(product_name.trim()==""){
        $('#pna_error').text("Product name is required!");
        isValue = false;
    }

    if(price.trim()==""){
        $('#ppa_error').text("Product price is required!");
        isValue = false;
    }

    if(isValue){
        $.ajax({
            type: "POST",
            url: "../../src/php/add_product.php",
            data: {addProduct:data},
            success: function(response){
                // console.log(response);
                window.location.href = "products.php";
            },
            error: function(error){
                // console.error("err ", error);
            }
        })
    }
} 

function updateProduct(){
    $('#pnu_error').text('');
    $('#ppu_error').text('');
        
    var product_name = $('#product_name').val();
    var description = $('#description').val();
    var price = $('#price').val();
    var stock = $('#stock').val();
    var hiddenData = $('#hiddenData').val();


    if(product_name.trim()==""){
        $('#pnu_error').text("Product name is required!.");
        if(price.trim()==""){
            $('#ppu_error').text("Product price is required!");
            return;
        }
        return;
    }
    if(price.trim()==""){
            $('#ppu_error').text("Product price is required!");
        return;
    }
        
    $.post("../../src/php/product_edit.php",{
        product_name:product_name,
        description:description,
        price:price,
        stock:stock,
        hiddenData:hiddenData
    }, function(data, status){
        $('#updateModal').modal('hide');
        $("#container").html(data);
        //window.location.replace("products.php");
        var parsedPrice = parseFloat(price).toFixed(2);
        var row = $('tr').filter(function() {
            return $(this).find('td').eq(0).text() == hiddenData;
        });

        row.find('td').eq(1).text(product_name);
        row.find('td').eq(2).text("₱ "+parsedPrice);
        if(stock > 0){
            row.find('td').eq(3).text(stock);
        } else {
            row.find('td').eq(3).text("-");
        }
    });
}

function getProduct(updateID){
    $('#hiddenData').val(updateID);
    
    $.post("../../src/php/product_edit.php", {updateID:updateID}, function(data, status){
        var product_id=JSON.parse(data);
        $('#product_name').val(product_id.product_name);
        $('#description').val(product_id.description);
        $('#price').val(product_id.price);
        $('#stock').val(product_id.stock);

        if(product_id.product_type == "Service"){
            $('#stock').attr('disabled', true);
            $('#product_name').attr('disabled', true);
        } else{
            $('#stock').attr('disabled', false);
            $('#product_name').attr('disabled', false);
        }
    });
}