<?php
	include_once ROOT. '/views/layouts/header.php';
?>

        <section>
            <div class="container">
                <div class="row">
                    
									<div class="col-sm-4 col-sm-offset-4 padding-right">
										

											<div class="signup-form">
												<h2>Вход на сайт</h2>
											
												<form action="#" method="post">
													<input type="email" name="email" placeholder="E-mail" value="<?php echo $email;?>">
													<input type="password" name="password" placeholder="Пароль" value="<?php echo $password;?>">
													<input type="submit" name="submit" class="btn btn-default" value="Войти">
												</form>

												<?php if( isset($errors) && is_array($errors)): ?>
													<?php foreach( $errors as $error ): ?>
														<p>- <?php echo $error; ?></p>
													<?php endforeach; ?>	
												<?php endif; ?>
												
											</div>

											<p>Если у вас нет учетной записи - то <a href="/user/register/">зарегистрируйтесь</a> на сайте</p>
									</div>

                </div>
            </div>
        </section>

<?php
	include_once ROOT. '/views/layouts/footer.php';
?>