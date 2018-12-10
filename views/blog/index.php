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
														<h2 class="title text-center">Статьи</h2>
														
														<?php foreach($listPublications as $publication): ?>
															<div class="single-blog-post">
																	<h3><a href="/blog/<?php echo $publication['id'];?>"><?php echo $publication['title'];?></a></h3>
																	<div class="post-meta">
																			<ul>
																					<li><i class="fa fa-calendar"></i><?php echo $publication['date'];?></li>
																			</ul>
																	</div>
																	<a href="">
																			<img src="/template<?php echo $publication['preview'];?>" alt="<?php echo $publication['title'];?>">
																	</a>
																	<p><?php echo $publication['short_content'];?></p>
																	<a  class="btn btn-primary" href="/blog/<?php echo $publication['id'];?>">Читать полностью</a>
															</div>
															<hr>
														<?php endforeach; ?>



                            
                            <!-- Постраничная навигация -->
														<div class="pagination_block" style="text-align: center;">
															<?php echo $pagination->get(); ?>
														</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<?php
	include_once ROOT. '/views/layouts/footer.php';
?>