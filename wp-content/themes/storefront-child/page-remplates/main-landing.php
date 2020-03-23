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
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade wow fadeIn"
                         data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            $content = $post->post_content;
                            $regex = '/https?\:\/\/[^\" \n]+/i';
                            preg_match_all($regex, $content, $matches);
                            while (have_posts()) : the_post();
                                if ($gallery = get_post_gallery(get_the_ID(), false)) :
                                    $i = 0;
                                    foreach ($gallery['src'] AS $src) {
                                        ?>
                                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                            <?php if ($matches[0][$i]): ?>
                                                <a href="<?= $matches[0][$i] ?>">
                                                    <img src="<?php echo $src; ?>" class="d-block w-100"
                                                         alt="Gallery image"/>
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo $src; ?>" class="d-block w-100"
                                                     alt="Gallery image"/>
                                            <?php endif; ?>
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
                            <div>
                                <img src="/wp-content/themes/storefront-child/svg/svg-prev-slide.svg" alt="prev">
                            </div>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <div>
                                <img src="/wp-content/themes/storefront-child/svg/svg-next-slide.svg" alt="next">
                            </div>
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
                    <p><?php echo nl2br(get_option('main_about_1')); ?></p>
                    <div class="main-info__img">
                        <img src="<?php echo nl2br(get_option('author_image')); ?>"
                             alt="sakrytina-avatar">
                    </div>
                    <p><?php echo nl2br(get_option('main_about_2')); ?></p>
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
            <div class="col-lg-4 col-md-8 offset-md-2 offset-0 col-12">
                <div class="main-social__card vk wow fadeInUp" data-wow-delay="0s">
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Группа в ВК</p>
                        <div class="main-social__card-mes">
                            <p class="left wow fadeInLeft" data-wow-delay="1s">Конкурс репостов 🎁</p>
                            <p class="right wow fadeInRight" data-wow-delay="1.5s">Открыт читательский чат 📚</p>
                            <p class="left wow fadeInLeft" data-wow-delay="2s">Анкета читателя 📋</p>
                            <p class="right wow fadeInRight" data-wow-delay="2.5s">Ответы на вопросы, о которых вы
                                боялись спросить 😱</p>
                            <p class="left wow fadeInLeft" data-wow-delay="3s">Творческие новости</p>
                            <p class="right wow fadeInRight" data-wow-delay="3.5s">А также! Арты, видео... скандалы,
                                интриги, расследования 😀</p>
                        </div>
                        <a class="btn btn-vk" target="_blank" href="https://vk.com/sakrytina_mariya"><img
                                    src="/wp-content/themes/storefront-child/svg/svg-vk-card.svg"
                                    alt="vk-icon">Перейти в вк</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="main-social__card inst wow fadeInUp" data-wow-delay="0.2s">
                    <?= do_shortcode('[instagram-feed]') ?>
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Аккаунт в Инстаграме</p>
                        <p><?php echo nl2br(get_option('instagram_text')); ?></p>
                        <p><br></p>
                        <a class="btn btn-inst" target="_blank"
                           href="https://www.instagram.com/sakrytina_maria_writer/">
                            <img src="/wp-content/themes/storefront-child/svg/svg-instagram-card.svg"
                                 alt="instagram-icon">Перейти в инстаграм
                        </a>
                    </div>
                </div>

                <div class="main-social__card fb wow fadeInUp" data-wow-delay="0.2s">
                    <img src="/wp-content/themes/storefront-child/images/img-fb.jpg" alt="image-fb">
                    <div class="main-social__card-body">
                        <p class="main-social__card-title">Страница на Facebook</p>
                        <p><?php echo nl2br(get_option('facebook_text')); ?></p>
                        <a class="btn btn-fb" target="_blank" href="https://www.facebook.com/sakrytina/">
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
                            <div class="col-lg-7 col-12 order-lg-1 order-2">
                                <p class="card-muse__header">Покорми котоМузу</p>
                                <img src="/wp-content/themes/storefront-child/images/img-muse.jpg" alt="muse">
                            </div>
                            <div class="col-lg-5 col-12">
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
                                    <form class="mb-0" method="POST"
                                          action="https://money.yandex.ru/quickpay/confirm.xml">
                                        <input type="hidden" name="receiver" value="410013256132918">
                                        <input type="hidden" name="formcomment"
                                               value="sakrytina.ru КотоМуза - донат">
                                        <input type="hidden" name="short-dest"
                                               value="КотоМуза на покормить">
                                        <input type="hidden" name="label" value="Донат">
                                        <input type="hidden" name="quickpay-form" value="donate">
                                        <input type="hidden" name="targets" value="транзакция донат">
                                        <input type="hidden" name="comment"
                                               value="На покормить">
                                        <input type="hidden" name="need-fio" value="true">
                                        <input type="hidden" name="need-email" value="true">
                                        <input type="hidden" name="need-phone" value="false">
                                        <input type="hidden" name="need-address" value="false">

                                        <div class="card-muse__input-group">
                                            <span id="inputDonateText">100</span>
                                            <input class="input-donate" type="number" name="sum" value="100" max="15000"
                                                   data-type="number">

                                            <div class="widget-shop__payments-base">
                                                <label class="radio-button__radio radio-button__radio_checked_yes radio-button__radio_side_left"
                                                       for="payByWallet">
                                                    <input class="radio-button__control"
                                                           value="PC" aria-label="Заплатить кошельком"
                                                           checked="checked" id="payByWallet"
                                                           type="radio"
                                                           name="paymentType"
                                                    >
                                                    <span class="radio-button__text">
                                                            <i class="icon widget-shop__icon widget-shop__icon_name_PC"
                                                               aria-hidden="true"></i>
                                                        </span>
                                                </label>
                                                <label class="radio-button__radio radio-button__radio_side_right"
                                                       for="payByCard">
                                                    <input class="radio-button__control"
                                                           value="AC"
                                                           aria-label="Заплатить картой"
                                                           id="payByCard"
                                                           type="radio"
                                                           name="paymentType"
                                                    >
                                                    <span class="radio-button__text">
                                                            <i class="icon widget-shop__icon widget-shop__icon_name_AC"
                                                               aria-hidden="true"></i>
                                                        </span>
                                                </label>
                                            </div>

                                            <input class="btn-donate" type="submit" value="Покормить">
                                    </form>
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
