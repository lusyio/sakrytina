<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

<div class="row" id="customer_login">
    <?php endif; ?>
    <div class="col-12 offset-0 col-lg-6 offset-lg-3 pl-lg-3 pr-lg-3 p-0" id="loginBlock">
        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action('woocommerce_login_form_start'); ?>

            <div class="row">
                <div class="col">
                    <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>
                        &nbsp;<span class="required">*</span></label>
                    <input type="text" class="form-control"
                           name="username"
                           placeholder="Введите логин или email"
                           id="username" autocomplete="username"
                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                class="required">*</span></label>
                    <input class="form-control" type="password" placeholder="Введите пароль"
                           name="password" id="password" autocomplete="current-password"/>
                </div>
            </div>

            <?php do_action('woocommerce_login_form'); ?>

            <div class="row login-block">
                <div class="col-lg-7 col-12 m-auto">
                    <label class="mb-3 p-0 woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme pure-material-radio">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                               name="rememberme"
                               type="checkbox" id="rememberme" value="forever"/>
                        <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                    </label>
                </div>
                <div class="col-lg-5 col-12">
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="btn btn-primary w-100"
                            name="login"
                            value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>

                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-between">
                    <?php
                    if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
                        <p class="register mb-0">
                            <a href="#" class="register-toggle toggle-form" data-target-form="register">Регистрация</a>
                        </p>
                    <?php endif; ?>
                    <p class="woocommerce-LostPassword lost_password mb-0">
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                    </p>
                </div>
            </div>

            <?php do_action('woocommerce_login_form_end'); ?>

        </form>
    </div>

    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <div class="col-12 offset-0 col-lg-6 offset-lg-3 pl-lg-3 pr-lg-3 p-0" id="registerBlock" style="display: none">

        <form method="post"
              class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >

            <?php do_action('woocommerce_register_form_start'); ?>

            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                <div class="row">
                    <div class="col">

                        <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                        <input type="text" class="form-control" name="username"
                               id="reg_username" autocomplete="username"
                               value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                    </div>
                </div>

            <?php endif; ?>

            <div class="row">
                <div class="col">
                    <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span
                                class="required">*</span></label>
                    <input type="email" class="form-control" name="email"
                           id="reg_email" autocomplete="email"
                           value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </div>
            </div>

            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                <div class="row">
                    <div class="col">
                        <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                                    class="required">*</span></label>
                        <input type="password" class="form-control"
                               name="password"
                               id="reg_password" autocomplete="new-password"/>
                    </div>
                </div>

            <?php else : ?>

                <p class="sent-email"><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

            <?php endif; ?>

            <?php do_action('woocommerce_register_form'); ?>

            <div class="row">
                <div class="col-lg-7 col-12 m-auto">
                    <p class="already-registered mb-3">
                        <a href="#" class="toggle-form" data-target-form="login">Я уже зарегистрирован</a>
                    </p>
                </div>
                <div class="col-lg-5 col-12">
                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    <button type="submit" class="btn btn-primary" name="register"
                            value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                </div>
            </div>

            <?php do_action('woocommerce_register_form_end'); ?>

        </form>
    </div>
</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>
