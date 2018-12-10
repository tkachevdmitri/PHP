<?php
	include_once ROOT. '/views/layouts/header.php';
?>

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
                        <div class="features_items"><!--features_items-->
														<!--<h2 class="title text-center">Последние товары</h2>-->

														<div class="row">
														<?php foreach($listProducts as $product):?>
															<div class="col-sm-4">
																	<div class="product-image-wrapper">
																			<div class="single-products">
																					<div class="productinfo text-center">
																							<img src="<?php echo Product::getImage($product['id']); ?>" alt="" />
																							<h2><?php echo $product['price']; ?> руб</h2>
																							<p>
																								<a href="/product/<?php echo $product['id'];?>">
																									<?php echo $product['name'];?>
																								</a>	
																							</p>
																							<a href="#" data-id="<?php echo $product['id'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
																					</div>
																					<?php if($product['is_new']):?>
																						<img src="/template/images/home/new.png" class="new" alt="new">
																					<?php endif;?>
																			</div>
																	</div>
															</div>
														<?php endforeach;?>
														</div>

														<!-- Постраничная навигация -->
														<div class="pagination_block" style="text-align: center;">
															<?php echo $pagination->get(); ?>
														</div>

                        </div><!--features_items-->

                    </div>
                </div>
            </div>
        </section>

<?php
	include_once ROOT. '/views/layouts/footer.php';
?>