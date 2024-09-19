
function printArea(){

    var print_area = window.open();
    var printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <title>Print Preview</Title>
        
                <style>
                    *{
                        margin: 0;
                        padding: 0;
                    }
        
                    body{
                        background-color: #a1a9b1;
                        font-family: monospace;
                    }
        
                    .container{
                        margin: .3cm auto;
                        padding: 1.5rem 1rem;
                        width: 343px;
                        height: 500px;
                        background-color: white;
                        border-radius: 20px;
                    }

                    h1{
                        font-weight: bold;
                        text-align: center;
                        font-size: 1.3rem;
                    }
        
                    hr{
                        border-top: 1px dashed black;
                    }

                    .orderNo{
                        width: 100%;
                        text-align: center;
                    }

                    p{
                        width: 65%;
                    }

                    .float-l{
                        float: left;
                    }

                    .float-r{
                        float: right;
                        width: 35%
                    }

                    .mb-1{
                        margin-bottom: 1.5em;
                    }

                    .o-items{
                        width: 100%;
                    }

                    .o-items th, .o-items td{
                        text-align: center;
                    }

                    .o-items tbody td:first-child{
                        text-align: left;
                    }
        
                    .o-items, .o-bill{
                        border: 0;
                    }

                    .o-bill td{
                        padding-right: 1em;
                    }

                    .o-bill tr td:nth-child(2){
                        text-align: right;
                    }

        
                    @media print{
                        @page{
                            margin: .5cm .3cm;
                        }

                        *{
                            font-size: 7pt;
                            margin: 0;
                            padding: 0;
                        }
                        
                        .container{
                            width: 100%;
                            height: auto;
                            margin: 0;
                            padding: 0;
                            border-radius: 0;
                        }

                        h1{
                            font-size: 15pt;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="container">
            `;

    print_area.document.write(printContent);
    print_area.document.write("<h1>ER LAUNDRY</h1>");
    print_area.document.write("<center>Pangke St., Sambag I Urgelio</center>");
    print_area.document.write("<center>Cebu City</center>");
    
    print_area.document.write("<hr style='margin: 1em 0 .5em;'><p class='orderNo'>" + $('#infoArea p:nth-child(2)').text() + "</p><hr style='margin: .5em 0 1em;'>");
    print_area.document.write("<p class='float-l'>" + $('#infoArea p:nth-child(5)').text() + "</p>");
    print_area.document.write("<p class='float-r'>" + $('#infoArea p:nth-child(3)').text() + "</p>");
    print_area.document.write("<p class='float-l'>" + $('#infoArea p:nth-child(6)').text() + "</p>");
    print_area.document.write("<p class='float-r mb-1'>" + $('#infoArea p:nth-child(4)').text() + "</p>");

    print_area.document.write($("#itemsArea").html());
    print_area.document.write("<br>");
    print_area.document.write($("#billArea").html());
    print_area.document.write("<br><hr><br><center> Thank You <br> Please Come Again </center>");
    
    print_area.document.close();
    print_area.focus();
    print_area.print();
    // print_area.close();

}