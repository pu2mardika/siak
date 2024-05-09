<!DOCTYPE html>  
<html lang="en">  

<head>  
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>BUKTI PENDAFTARAN</title>
    <style>
        body { 
            background-image: url('images/bg_mbc.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center; 
        }
        .myQR {
            border: 5px outset blue;
            background-color: lightblue;    
            text-align: center;
        }
    </style>
</head>  

<body>  
    <?= view_cell('Modules\Register\Libraries\Widget::buktidaftar', $rsdata) ?>
</body>  

</html>