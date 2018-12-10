<?php
	include_once ROOT. '/views/layouts/header.php';
?>

        <section>
            <div class="container">
                <div class="row">
                    
									<div class="col-sm-4 col-sm-offset-4 padding-right">
										
										<?php if($result):?>	
											<p>Изменения успешно сохранены!</p>
										<?php else: ?>
											<div class="signup-form">
												<h2>Редактирование личных данных</h2>
											
												<form action="#" method="post">
													<p>Имя</p>
													<input type="text" name="name" placeholder="Имя" value="<?php echo $name;?>">
													<p>Пароль</p>
													<input type="password" name="password" placeholder="Пароль" value="<?php echo $password;?>">
													<input type="submit" name="submit" class="btn btn-default" value="Изменить">
												</form>

												<?php if( isset($errors) && is_array($errors)): ?>
													<?php foreach( $errors as $error ): ?>
														<p>- <?php echo $error; ?></p>
													<?php endforeach; ?>	
												<?php endif; ?>

											</div>
										<?php endif; ?>
									
									</div>

                </div>
            </div>
        </section>

<?php
	include_once ROOT. '/views/layouts/footer.php';
?>