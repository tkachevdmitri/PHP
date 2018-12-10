<?php
	include_once ROOT. '/views/layouts/header.php';
?>

        <section>
            <div class="container">
                <div class="row">
                    
									<div class="col-sm-4 col-sm-offset-4 padding-right">
										
										<?php if($result): ?>
											<p>Поздравляем! Вы успешно зарегистрировались на сайте.</p>
										<?php else: ?>
											<div class="signup-form">
												<h2>Регистрация на сайте</h2>
											
												<form action="#" method="post">
													<input type="text" name="name" placeholder="Имя" value="<?php echo $name;?>">
													<input type="email" name="email" placeholder="E-mail" value="<?php echo $email;?>">
													<input type="password" name="password" placeholder="Пароль" value="<?php echo $password;?>">
													<input type="submit" name="submit" class="btn btn-default" value="Регистрация">
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