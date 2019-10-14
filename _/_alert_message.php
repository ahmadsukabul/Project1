                        <?PHP 
							if(isset($_GET['e'])){
							?>
							<div class="alert alert-danger alert-fill alert-close alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<i class="font-icon font-icon-inline font-icon-warning"></i>
									<strong>Ada Masalah!!</strong><br>
									<?PHP echo $_SESSION['error_msg']; ?>
							</div>
							<?PHP } ?>
							
							
							<?PHP 
							if(isset($_GET['s'])){
							?>
							<div class="alert alert-success alert-fill alert-close alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<i class="fa fa-check"></i>
									<strong>Berhasil!!</strong><br>
									<?PHP echo $_SESSION['success_msg']; ?>
							</div>
						<?PHP } ?>