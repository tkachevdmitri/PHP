<?php
	include_once ROOT. '/views/layouts/header.php';
?>

        <section>
            <div class="container">
                <div class="row">
                    
									<div class="col-sm-4 col-sm-offset-4 padding-right">
										
										<?php if($result): ?>
											<p>Сообщение отправлено! Мы ответим Вам на указанный email.</p>
										<?php else: ?>
											<div class="signup-form">
												<h2>Обратная связь</h2>
												<p><strong>Есть вопрос? Напишите нам.</strong></p>
												
												<br>
												<form action="#" method="post">
													<input type="email" name="email" placeholder="E-mail" value="<?php echo $userEmail; ?>">
													<textarea name="message" placeholder="Ваше сообщение"></textarea>
													<input type="submit" name="submit" class="btn btn-default" value="Отправить">
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