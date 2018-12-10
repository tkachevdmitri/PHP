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
																					<h4 class="panel-title">
																						<a href="/category/<?php echo $categoriesItem['id'];?>" class="<?php if($category_id == $categoriesItem['id']) echo 'active'; ?>">
																							<?php echo $categoriesItem['name'];?>
																						</a>
																					</h4>
																			</div>
																	</div>
																<? endforeach;?>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="product-details"><!--product-details-->
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="view-product">
                                        <img src="<?php echo Product::getImage($product['id']); ?>" alt="" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
																		<div class="product-information"><!--/product-information-->
																				<?php if($product['is_new']):?>
                                        	<img src="/template/images/product-details/new.jpg" class="newarrival" alt="" />
																				<?php endif;?>
																				<h2><?php echo $product['name'];?></h2>
                                        <p>Код товара: <?php echo $product['code'];?></p>
                                        <span>
                                            <span><?php echo $product['price'];?> руб.</span>
                                            <label>Количество:</label>
                                            <input type="text" value="3" />
                                            <button type="button" data-id="<?php echo $product['id'];?>" class="btn btn-fefault cart add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                В корзину
                                            </button>
                                        </span>
                                        <p><b>Наличие:</b> На складе</p>
                                        <p><b>Состояние:</b> Новое</p>
                                        <p><b>Производитель:</b> <?php echo $product['brand'];?></p>
                                    </div><!--/product-information-->
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-sm-12">
                                    <h5>Описание товара</h5>
                                    <?php echo $product['description'];?>
                                </div>
                            </div>
                        </div><!--/product-details-->

                    </div>
                </div>
            </div>
        </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>