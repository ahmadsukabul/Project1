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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<?PHP require_once("_/css.php")?>
</head>
<body class="with-side-menu">
	<?PHP require_once("_/header.php"); ?>
	<?PHP require_once("_/sidebar.php");     ?>
	
	<div class="page-content">
	    <div class="container-fluid">
	        <div class="row">
	            <div id="pageData">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kode produk</th>
                            <th>Nama produk</th>
                            <th>UUI</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kode produk</th>
                            <th>Nama produk</th>
                            <th>UUI</th>

                        </tr>
                    </tfoot>
                </table>
                </div>
				<span class="flash"></span>
	        </div>
	    </div><!--.container-fluid-->
	</div><!--.page-content-->

	<?PHP //require_once("_/js.php"); ?>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        var editor;
        $(document).ready(function() {
            // $('#example').DataTable( {
            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": "load.transaksi.php"
            // } );
            editor = new $.fn.dataTable.Editor( {
            ajax: "load.transaksi.php",
            table: "#example",
            fields: [ {
                    label: "Kode produk:",
                    name: "transaksi.kode_produk"
                }, {
                    label: "Nama produk:",
                    name: "transaksi.nama_produk"
                },{
                    label: "UUI:",
                    name: "transaksi.users",
                    type: "select",
                    placeholder: "Select a location"
                }
            ]
        } );
    
            // $('#example').DataTable( {
            //     dom: "Bfrtip",
            //     ajax: {
            //         url: "../php/join.php",
            //         type: 'POST'
            //     },
            //     columns: [
            //         { data: "users.first_name" },
            //         { data: "users.last_name" },
            //         { data: "users.phone" },
            //         { data: "sites.name" }
            //     ],
            //     select: true,
            //     buttons: [
            //         { extend: "create", editor: editor },
            //         { extend: "edit",   editor: editor },
            //         { extend: "remove", editor: editor }
            //     ]
            // } );
        } );
    </script>
</body>
</html>
