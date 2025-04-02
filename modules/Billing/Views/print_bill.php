<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
<style>
    @page { margin:30px 30px 80px 30px; }
	h3 {color: DarkRed; text-align: right; margin:15px 0 10px 0; font-size:26px;}
    
	table{width: 100%; border-collapse: collapse;
	    /*font-size: 14px; font-family: Arial, Helvetica, sans-serif;*/
    }
	table th{
		height:40px;
        background: #778899;
        color: #FFF;
        border: 1px solid #FFF;	
	}

    table td{
        vertical-align: text-top;
        border-bottom: 1px solid #778899;
    }

    table td span, table th span{
        padding: 2px 4px 2px 0;
    }

    table td > div{
        padding: 2px 0;
        min-height: 80px;
    }
	
    table tfoot th{
        text-align: right;
        font-weight: bold;
        background: #fff;
        border: none;
        color:#000;
        height:25px;
    }
    table tfoot td{
        vertical-align: middle;
        text-align: right;
        border-bottom: 1px solid #778899;
    }

    .col{
        float: left;
    }

    .col1{
        width: 55%;
        padding 0 30px 0 0;
    }
    .col2{
        width: 45%;
    }

    .clearfix {
        clear: left;
        margin-top:-20px;
    }

	.mybarcode{
        height:50px;
        text-align: center;
        padding:3px;
        width: 330px;
        border: 1px outset blue;
        float:left;
    }
    .barcode-text {
        letter-spacing: 8px;
        margin-top: 1px;
        display: block;
        font-size: 11px;
    }
   
	#barcode{
        width: 400px;
        margin-right: 10px;
    }
	.rows{
        display:grid;
        grid-template-columns: auto auto;
        background:#FFFFFF;
        padding: 0 1em;
	}

    .container{
        padding: 0 1em;
    }

    #tagihan {
        color: DarkBlue; 
        text-align: right; 
        margin:-8px 0 0 0; 
        font-size:26px;
    }

    #otorized{
        text-align: center;
    }
    #otorized strong{
        text-decoration: underline;
    }
    #catatan{
       /* border: 1px solid #778899; */
        padding: 4px;
        position: fixed; left: 0px; bottom: 10px; right: 0px; 
        height: 125px;
    }

    .copyright{
        float:right;
        font-size: 9pt;
        text-align:right;
    }

    a{
        text-decoration: none;
    }

    #footer{ position: fixed; left: 0px; bottom: -80px; right: 0px; 
             height: 80px; border-top: 2px solid DarkGoldenRod; padding-top:2px;}
    #footer .page:after { content: counter(page);}
    .clearfix{clear: both; display: table;}
  /*  #footer .page:after { content: counter(page, upper-roman); } */
    ul {
        margin:0;padding:0;
        list-style-type: none
    }
    ul li span {
        display:block;
        font-size:12px;
    }

    ul.styled {
        list-style-type: disc;
        margin: 0 14px;
        padding: 0;
        font-size:11pt;
    }
</style>
</head>
<body>
	<header class="rows">
        <div id="corporate" class="col col1">
            <img src="<?=$company['logo']?>" alt="LOGO"  height="60" width="180"/>
            <ul>
                <li><?= $company['name']?></li>
                <li><?= $company['address1']." ".$company['address2']?></li>
                <li>Desa/Kelurahan <?= $company['desa']?> Kec. <?= $company['kecamatan']?></li>
                <li><?= $company['city'].", ".$company['postal']?></li>
                <li>Phone <?= $company['phone']?>, Handphone: <?= $company['mobile']?></li>
                <li>Website <?= $company['website']?>, e-mail: <?= $company['email']?></li>
                <li>NPWP/Tax ID # <?= $company['npwp']?></li>
            </ul>
            <br/>
            <div>
                <strong>BILLED TO:</strong><br/>
                <?php
                foreach($reciver as $v){
                    echo $v."<br/>";
                }
                ?>            
            </div>
            <br/>
        </div>
        <div id="reciver" class="col col2">
            <h3>INVOICE</h3>
            <ul>
                <li>No Tagihan/Invoice No# <?= $billing['id']?></li>
                <?php if(array_key_exists('accID',$billing)){echo "<li>Akun Billing/Billing Account# ".$billing['accID']."</li>";}?>
                <li>Tgl. Tagihan/Invoice Issued # <?= format_date($billing['issued'])?></li>
                <?php $tagihan = $billing['amount'] - $billing['diskon']; ?>
                <li>Jatuh Tempo/Due Date # <?= format_date($billing['due_date'])?></li>
                <li>Register ID #<?=$billing['regID']?></li>
            </ul>
            <div>
                <strong>
                Jumlah Tagihan Anda <br/> Your Bill Total
                <h2 id="tagihan">IDR <span><?= format_angka($tagihan)?></span></h2>
                <strong>
            </div>
        </div>
        <div class="clearfix"></div>
    </header>    
	<div id="footer">
        <div class="mybarcode">
            <?=$barcode?>
            <span class="barcode-text"><?php echo $billing['id'] ?></span>
        </div>
        <div class="copyright">
            Copyright <span><?=str_replace('{{YEAR}}', substr($billing['issued'],0,4), setting()->get('MyApp.footer'))?><br>
            PDF Generated on <?=date("d-m-Y H:i:s")?> by <?=$user['username']?> 
        </div>
        <span class="clearfix"></span>
   </div>
	<div class="container">
		<strong>Rincian Tagihan / Bill Details</strong>
        <table class="data-raport">
			<thead>
				<tr>
					<th width="70%">Keterangan/Description</th>
					<th width="30%">Jumlah Harga/Amount (IDR)</th>
				</tr>
			</thead>
			<tbody>
                <tr>
                    <td><div><?= $billing['deskripsi'] ?> </div></td>
                    <td align="right"><span><?= format_angka($billing['amount'])?></span></td>
                </tr>
			</tbody>
            <tfoot>
                <tr>
                    <th><span>Total</span></th>
                    <td><span><?= format_angka($billing['amount'])?></span></td>
                </tr>
                <tr>
                    <th><span>Diskon/Discount</span></th>
                    <td><span><?= format_angka($billing['diskon'])?></span></td>
                </tr>
                <tr>
                    <th><span>Jumlah Tagihan/Amount</span></th>
                    <td><span><?= format_angka($tagihan)?></span></td>
                </tr>
            </tfoot>
		</table>
        Terbilang: # <?=proper(terbilang($tagihan))?> Rupiah #
        <br><br>
        <div>
            <div class="col col1">
                <?=$qrcode?>
            </div>
            <div id="otorized" class="col col2">
                <?=$company["locus"]?>, <?= format_date($billing['issued'])?>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <strong>X<?=$user['fullname']?></strong>
            </div>
        </div>
        <div id="paymetod" class="clearfix"></div>
        <div id="catatan">
            <span><strong>CATATAN:</strong></span>
            <ul class="styled">
                <li>Pembayaran melalui transfer bank dialamatkan ke: <strong>Bank Mandiri,
                    dengan Nomor Rekening: 1450011062318, <br>atas nama: Mandiri Bina Cipta</strong>
                </li>
                <li>Pembayaran melalui transfer bank, kemungkinan dikenakan biaya tambahan sesuai kebijakan bank masing-masing</li>
                <li>Invoice ini dibuat dengan sistem komputerisasi dan bisa di lihat secara onlie dengan mengklik tautan yang ada pada QRCODE di atas.</li>
                <li>Apabila ada pertanyaan terkait invoice ini, silakan hubungi kami pada kontak yang tertera di atas</li>
            </ul>
            
        </div>
	</div>
</body>
</html>
