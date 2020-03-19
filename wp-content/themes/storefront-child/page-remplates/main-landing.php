<?php
/*
Template Name: main-landing
Template Post Type: post, page, product
*/
?>

<?php get_header(); ?>

</div>
</div>
<div class="after-header">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="slider-container">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            while (have_posts()) : the_post();
                                if ($gallery = get_post_gallery(get_the_ID(), false)) :
                                    $i = 0;
                                    foreach ($gallery['src'] AS $src) {
                                        ?>
                                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                            <img src="<?php echo $src; ?>" class="d-block w-100" alt="Gallery image"/>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                endif;
                            endwhile;
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <img src="/wp-content/themes/storefront-child/svg/svg-prev-slide.svg" alt="prev">
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <img src="/wp-content/themes/storefront-child/svg/svg-next-slide.svg" alt="next">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-info">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <p>
                        Пишу фэнтези, от тёмного до юмористического. За 10-ть лет написала больше 20-ти романов и около
                        50-ти рассказов. В АСТ изданы 6-ть моих романов, 2 готовятся к публикации
                    </p>


                    <div class="main-info__img">
                        <img src="/wp-content/themes/storefront-child/images/sakrytina-avatar.png"
                             alt="sakrytina-avatar">
                    </div>
                    <p>
                        Общий тираж: 13500 экземпляров. Награждена национальной премией для молодых писателей «Русское слово». Творчество для меня не хобби, это моя жизнь.
                    </p>
                </div>
            </div>
            <div class="col-12">
                <h1>Мария Сакрытина</h1>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/popular', 'popular'); ?>

<div class="main-social">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="main-social__header">Подписывайся на социальные сети!</p>
            </div>
            <div class="col-4">
                <div class="main-social__card vk">
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Группа в ВК</p>
                        <div class="main-social__card-mes">
                            <p class="left">Конкурс репостов 🎁</p>
                            <p class="right">Открыт читательский чат 📚</p>
                            <p class="left">Анкета читателя 📋</p>
                            <p class="right">Ответы на вопросы, о которых вы боялись спросить 😱</p>
                            <p class="left">Творческие новости</p>
                            <p class="right">А также! Арты, видео... скандалы, интриги, расследования 😀</p>
                        </div>
                        <a class="btn btn-vk" href="#"><img
                                    src="/wp-content/themes/storefront-child/svg/svg-vk-card.svg"
                                    alt="vk-icon">Перейти в вк</a>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="main-social__card inst">
                    <?= do_shortcode('[instagram-feed]') ?>
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Аккаунт в Инстаграме</p>
                        <p>- каждый день новые посты</p>
                        <p>- рассказываю о себе, котомузе и книгах</p>
                        <p><br></p>
                        <a class="btn btn-inst" href="#">
                            <img src="/wp-content/themes/storefront-child/svg/svg-instagram-card.svg"
                                 alt="instagram-icon">Перейти в инстаграм
                        </a>
                    </div>
                </div>

                <div class="main-social__card fb">
                    <img src="/wp-content/themes/storefront-child/images/img-fb.jpg" alt="image-fb">
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Страница на Facebook</p>
                        <p>каждый день - только главные</p>
                        <p>творческие новости</p>
                        <a class="btn btn-fb" href="#">
                            <img src="/wp-content/themes/storefront-child/svg/svg-fb-card.svg"
                                 alt="fb-icon">Перейти в facebook
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card-muse">
                    <div class="card-muse__body">
                        <div class="row">
                            <div class="col-7">
                                <p class="card-muse__header">Покорми котоМузу</p>
                                <img src="/wp-content/themes/storefront-child/images/img-muse.jpg" alt="muse">
                            </div>
                            <div class="col-5">
                                <div class="card-muse__right">
                                    <p class="card-muse__title">
                                        Муза мнет лапками автора и дарит вдохновение. У автора получается интересная
                                        книга.
                                        Доволен работой котоМузы? Поблагодари её! 😼
                                    </p>
                                    <p class="card-muse__content">
                                        Муза + автор = интересная книга 😼
                                        Муза + вкусняшка = вдохновение 😼
                                    </p>
                                    <div class="card-muse__input-group">
                                        <input type="text">
                                        <button>Покормить</button>
                                    </div>
                                    <p class="card-muse__footer">
                                        Перевод денег осуществляется с помощью сервиса Яндекс.Деньги. После нажатия
                                        кнопки
                                        “Перевести” вы будете перенаправлены на страницу подтверждения перевода
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php get_footer(); ?>
