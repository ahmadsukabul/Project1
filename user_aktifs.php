<?PHP
$auto_connect = 1; //auto connect database;
require_once("config.php");
require_once("_/_session.php");
require_once("_/_session_level_1.php");
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Jabber Outbox - <?PHP echo $c_name; ?></title>
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
    


	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php"); ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div id="pageData" class="col-lg-12 col-md-12">
                <section class="card card-blue">
						<header class="card-header">
							Semua Transaksi
						</header>
						<div class="card-block">
                            Total Transaksi : 
                            <?PHP
                                $sql = "SELECT * FROM verify_id where status = '1'";

                                echo $db->num_rows($sql)  ?><p>
							
                        
							<div id="pageData">
                                <!-- <table> -->
                                <table id="user_dat" class="display table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama KTP</th>
                                            <th>Provinsi</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
							<span class="flash"></span>
						</div>
					</section>
                </div>
				<span class="flash"></span>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<script src="js/lib/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
    
		<script src="js/lib/datatables-net/datatables.min.js"></script>
    <script>
        $(document).ready(function()
        {
            $('#user_dat').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url" : "http://localhost/2019/bukakios/admin.bukakios.net/ajax/load_data_aktif.php",
                    // "type" : "POST"
                },
                "columns": [
                    // if (dat)
                    { "data": "id" },
                    { "data": "nama_ktp" },
                    { "data": "provinsi" },
                    { "data": "kecamatan" },
                    { "data": "kelurahan" },
                    { "data": "status" },
                ]
            });
            // alert(recordsTotal);


            // $('#user_dat').DataTable();
            // var dataTable = $('#user_dat').DataTable({  
            //     "processing":true,  
            //     "serverSide":true,  
            //     "order":[],  
            //     "ajax":{  
            //             url:"http://localhost/2019/bukakios/admin.bukakios.net/ajax/load_data_aktif.php",  
            //             type:"POST"  
            //     },  
            //     "columnDefs":[  
            //             {  
            //                 "targets":[0, 3, 4],  
            //                 "orderable":false,  
            //             },  
            //     ],  
            // }); 

            // $('#user_dat').DataTable( {
            //     "processing": true,
            //     "serverSide": true,
            //     ajax: {
            //         url: 'http://localhost/2019/bukakios/admin.bukakios.net/ajax/load_data_aktif.php',
            //         dataFilter: function(data){
            //             console.log(data);
            //             var json = jQuery.parseJSON( data );
            //             json.recordsTotal = json.total;
            //             json.recordsFiltered = json.total;
            //             json.data = json.list;
            
            //             return JSON.stringify( json ); // return JSON string
            //         },
                    // "columns": [
                    //     // if (dat)
                    //     { "data": "id" },
                    //     { "data": "nama_ktp" },
                    //     { "data": "provinsi" },
                    //     { "data": "kecamatan" },
                    //     { "data": "kelurahan" },
                    //     { "data": "status" },
                    // ]
                // }
            // } );
        });
    </script>
</body>
</html>
