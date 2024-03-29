<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/public/partials
 */

// Get config data
$whatsapp_link = $this->options['whatsapp_link']; // api.whatsapp.com or web.whatsapp.com
$phone_number = $this->options['phone_number'];
$target = $this->options['target']; // _self or _blank
// $arg is in the parent file

?>
<div class="<?php echo $arg['div_class'] ?>">
    <a class="<?php echo $arg['woocommerce_class'] ?> button alt wayra-coc-button <?php echo $arg['extra_class'] ?>" href="<?php echo $whatsapp_link . $phone_number . '&text=' . $arg['text']; ?>" rel="noreferrer" alt="<?php echo $arg['button_text'] ?>"  target="<?php echo $target ?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#fff" d="M3.516 3.516c4.686-4.686 12.284-4.686 16.97 0 4.686 4.686 4.686 12.283 0 16.97a12.004 12.004 0 01-13.754 2.299l-5.814.735a.392.392 0 01-.438-.44l.748-5.788A12.002 12.002 0 013.517 3.517zm3.61 17.043l.3.158a9.846 9.846 0 0011.534-1.758c3.843-3.843 3.843-10.074 0-13.918-3.843-3.843-10.075-3.843-13.918 0a9.846 9.846 0 00-1.747 11.554l.16.303-.51 3.942a.196.196 0 00.219.22l3.961-.501zm6.534-7.003l-.933 1.164a9.843 9.843 0 01-3.497-3.495l1.166-.933a.792.792 0 00.23-.94L9.561 6.96a.793.793 0 00-.924-.445 1291.6 1291.6 0 00-2.023.524.797.797 0 00-.588.88 11.754 11.754 0 0010.005 10.005.797.797 0 00.88-.587l.525-2.023a.793.793 0 00-.445-.923L14.6 13.327a.792.792 0 00-.94.23z"/></svg>
        <?php echo $arg['button_text'] ?>
    </a>
</div>