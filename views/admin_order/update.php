<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/order">Управление заказами</a></li>
                    <li class="active">Редактировать заказ</li>
                </ol>
            </div>


            <h4>Редактировать заказ #<?php echo $id; ?></h4>

            <br/>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post">

                        <p>Имя клиента</p>
                        <input type="text" name="name" placeholder="" value="<?php echo $order['name']; ?>">

                        <p>Телефон клиента</p>
                        <input type="text" name="phone" placeholder="" value="<?php echo $order['phone']; ?>">

                        <p>Комментарий клиента</p>
                        <input type="text" name="comment" placeholder="" value="<?php echo $order['comment']; ?>">


                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?php if ($order['status'] == 1) echo ' selected="selected"'; ?>>Новый заказ</option>
                            <option value="2" <?php if ($order['status'] == 2) echo ' selected="selected"'; ?>>В обработке</option>
														<option value="3" <?php if ($order['status'] == 3) echo ' selected="selected"'; ?>>Доставляется</option>
														<option value="4" <?php if ($order['status'] == 4) echo ' selected="selected"'; ?>>Отменен</option>
                            <option value="5" <?php if ($order['status'] == 5) echo ' selected="selected"'; ?>>Закрыт</option>
                        </select>
                        <br>
                        <br>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>