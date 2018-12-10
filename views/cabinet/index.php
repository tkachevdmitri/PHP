<?php
	include_once ROOT. '/views/layouts/header.php';
?>

        <section>
            <div class="container">
							<h1>Личный кабинет</h1>
							<h3><?php echo $user['name']; ?>, приветствуем вас на нашем сайте!</h3>
							<ul>
								<li><a href="/cabinet/edit">Редактировать личные данные</a></li>
								<li><a href="/user/history">История заказов</a></li>
							</ul>	
							
            </div>
        </section>

<?php
	include_once ROOT. '/views/layouts/footer.php';
?>