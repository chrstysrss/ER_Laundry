
$('#add_wash').click(function(){
    addService("Wash", $('#add_wash').attr("value"), "1");
    $('#add_wash').attr('disabled', true);
})

$('#add_dry').click(function(){
    addService("Dry", $('#add_dry').attr("value"), "2");
    $('#add_dry').attr('disabled', true);
})

$('#add_dropoff').click(function(){
    addService("Drop-off", $('#add_dropoff').attr("value"), "3");
    $('#add_dropoff').attr('disabled', true);
})


function addService(name, price, pid){
    var tr = $('<tr></tr>');
    tr.attr('data-id', pid)
    tr.append('<td><input type="hidden" name="prod_id[]" value="'+pid+'">'+name+'</td>');
    tr.append('<td><input type="hidden" name="prod_price[]" value="'+price+'">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</td>');
    tr.append('<td class="text-center px-2"><input type="number" name="prod_qty[]" min="1" max="50" value="1"></td>');
    tr.append('<td class="t-20"><input type="hidden" name="prod_total[]" value="'+price+'"><p class="m-0">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</p></td>');
    tr.append('<td class="text-center p-0 pe-2"><div class="d-flex justify-content-center"><i class="fa-regular fa-trash-can fa-lg" onclick="delete_list($(this))"></i></div></td>');

    $('#product_list').append(tr)
    calc()

    $('[name="prod_qty[]"]').on('keyup keydown keypress change',function(){
        calc();
    })
}


$('#add_consumable').click(function(){
    var prod = $('#consumables :selected').val();

    if($('#product_list tr[data-id="'+prod+'"]').length > 0){
        alert('Consumable already exists.','warning')
        return false;
    }

    var pname = $('#consumables option[value="'+prod+'"]').text();
    var price = $('#consumables option[value="'+prod+'"]').attr('data-price');
    var stock = $('#consumables option[value="'+prod+'"]').attr('data-stock');

    var tr = $('<tr></tr>');
    tr.attr('data-id',prod)
    tr.append('<td><input type="hidden" name="prod_id[]" value="'+prod+'">'+pname+'</td>');
    tr.append('<td><input type="hidden" name="prod_price[]" value="'+price+'">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</td>');
    tr.append('<td class="text-center px-2"><input type="number" name="prod_qty[]" min="1" max="'+stock+'" value="1"></td>');
    tr.append('<td class="t-20"><input type="hidden" name="prod_total[]" value="'+price+'"><p class="m-0">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</p></td>');
    tr.append('<td class="text-center p-0 pe-2"><div class="d-flex justify-content-center"><i class="fa-regular fa-trash-can fa-lg" onclick="delete_list($(this))"></i></div></td>');

    $('#product_list').append(tr)
    $('#consumables option[value="'+prod+'"]').attr('disabled', true);
    calc()

    $('[name="prod_qty[]"]').on('keyup keydown keypress change',function(){
        calc();
    })
})


function delete_list(_this){
    var pid = _this.closest('tr').attr('data-id');
    _this.closest('tr').remove()

    switch(pid){
        case "1":
            $('#add_wash').attr('disabled', false);
            break;
        case "2":
            $('#add_dry').attr('disabled', false);
            break;
        case "3":
            $('#add_dropoff').attr('disabled', false);
            break;
        default:
            $('#consumables option[value="'+pid+'"]').attr('disabled', false);
    }

    calc()
}


$('#discount').change(function(){
    calc()
})


function calc(){
    var grandtotal = 0;
    var discount = $('[name="discount"]').val()

    $('#product_list tbody tr').each(function(){
        var _this = $(this)
        var weight = _this.find('[name="prod_qty[]"]').val()
        var unit_price = _this.find('[name="prod_price[]"]').val()
        var total = parseFloat(weight) * parseFloat(unit_price)
        _this.find('[name="prod_total[]"]').val(total)
        _this.find('[name="prod_total[]"]').siblings('p').html(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
        grandtotal+= total;
    })

    grandtotal -= discount;

    $('[name="grandtotal"]').val(grandtotal)
    $('#tamount').html(parseFloat(grandtotal).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
    $('#tamount1').html(parseFloat(grandtotal).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
    
    $('[name="received"]').attr('value', grandtotal)
    change()
}

$('[name="received"]').change(function(){
    change()
})

function change(){
    var received = $('[name="received"]').val();
    var total = $('[name="grandtotal"]').val();
    var change = parseFloat(received) - parseFloat(total)
    change = parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2})
    if(change > 0){
        $('[name="amount_change"]').val(change)
        $('#amount_change').html(parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
    }
}

$('#resetbtn').click(function(){
    location.reload();
})

$('#process-laundry').submit(function(e){
    var data = $("#process-laundry").serialize();
    $.ajax({
        type : 'POST',
        url : '../../src/php/save_order.php',
        data : data,
        success : function(response) {
            var res = JSON.parse(response);
            alert(res["message"]);
            if(res["status"] == 200){
                setTimeout(function(){
                    location.reload()
                },800)
            }  
        }
    });

    e.preventDefault();
})

