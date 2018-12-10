<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
							<div class="col-sm-3">
								<div class="left-sidebar">
										<h2>Каталог</h2>
										<div class="panel-group category-products">
												<?php foreach($categoriesList as $categoriesItem):?>
													<div class="panel panel-default">
															<div class="panel-heading">
																	<h4 class="panel-title"><a href="/category/<?php echo $categoriesItem['id'];?>"><?php echo $categoriesItem['name'];?></a></h4>
															</div>
													</div>
												<? endforeach;?>
										</div>

								</div>
						</div>	

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Корзина</h2>


                    <?php if ($result): ?>
                        <p>Заказ оформлен. Мы Вам перезвоним.</p>
                    <?php else: ?>

                        <p>Выбрано товаров: <?php echo $totalQuantity; ?>, на сумму: <?php echo $totalPrice; echo '<br>';   echo $userId; ?>, руб</p> <br/>

                        <?php if (!$result): ?>                        

                            <div class="col-sm-4">
                                <?php if (isset($errors) && is_array($errors)): ?>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li> - <?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>

                                <div class="login-form">
                                    <form action="#" method="post">

                                        <p>Ваше имя</p>
                                        <input type="text" name="name" placeholder="" value="<?php echo $name; ?>"/>

                                        <p>Номер телефона</p>
                                        <input type="text" name="phone" placeholder="" value="<?php echo $phone; ?>"/>

                                        <p>Комментарий к заказу</p>
                                        <input type="text" name="comment" placeholder="Сообщение" value="<?php echo $comment; ?>"/>

                                        <br/>
                                        <br/>
                                        <input type="submit" name="submit" class="btn btn-default" value="Оформить" />
                                    </form>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>