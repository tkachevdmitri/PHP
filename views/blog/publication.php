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
                    <div class="col-sm-9">
                        <div class="blog-post-area">
                            <h2 class="title text-center">Запись в блоге</h2>
                            <div class="single-blog-post">
                                <h3><?php echo $itemPublication['title'];?></h3>
                                <div class="post-meta">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i><?php echo $itemPublication['date'];?></li>
                                    </ul>
																</div>
																
																<img src="/template<?php echo $itemPublication['preview'];?>" alt="<?php echo $itemPublication['title'];?>">
																
																<div class="post-content">
																	<br>
																	<?php echo $itemPublication['content'];?>
																</div>

                                <div class="pager-area">
                                    <div class="pager pull-right">
                                        <a href="/blog">Назад в блог</a>
                                    </div>
                                </div>
                            </div>
                        </div><!--/blog-post-area-->

                    </div>	
                </div>
            </div>
        </section>


<?php
	include_once ROOT. '/views/layouts/footer.php';
?>