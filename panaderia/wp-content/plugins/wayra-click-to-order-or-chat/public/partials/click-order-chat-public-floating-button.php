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
$floating_button = $this->options['floating_button'];
$floating_text = $this->options['floating_text']; // 'Hi, i have a question';
$floating_label_text = nl2br( $this->options['floating_label_text'] ); // 'Message us on WhatsApp';
$hide_on_mobile = $this->options['hide_on_mobile'] ? 'hide-on-mobile' : '';
$extra_class = ( 2 == $floating_button ) ? '' : 'wayra-coc-floating-style2';
?>
<a href="<?php echo $whatsapp_link . $phone_number . '&text=' . $floating_text; ?>" rel="noreferrer" title="<?php echo $floating_label_text ?>" alt="<?php echo $floating_label_text ?>" target="<?php echo $target ?>" class="wayra-coc-floating-button <?php echo $extra_class . ' ' . $hide_on_mobile; ?> wayra-coc-floating">
    
    <?php if ( 2 == $floating_button ) { ?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" alt="WhatsApp logo" enable-background="new 0 0 500 500" viewBox="0 0 500 500" width="65px"><filter id="shadow"><feDropShadow x="10" dy="13" stdDeviation="10" floodColor="#222222" floodOpacity="0.5" /></filter><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="250.1221" x2="250.1221" y1="455.5406" y2="49.3466"><stop offset="0" stop-color="#20b038"/><stop offset="1" stop-color="#60d66a"/></linearGradient><linearGradient id="b" gradientUnits="userSpaceOnUse" x1="250.1235" x2="250.1235" y1="462.821" y2="42.0608"><stop offset="0" stop-color="#f9f9f9"/><stop offset="1" stop-color="#fff"/></linearGradient><path fill="#fff" d="m40.683 462.821 29.589-108.039c-18.25-31.619-27.851-67.489-27.838-104.236.046-114.958 93.602-208.485 208.566-208.485 55.789.024 108.153 21.738 147.533 61.145 39.375 39.41 61.05 91.795 61.031 147.508-.049 114.953-93.619 208.497-208.564 208.497-.008 0 .005 0 0 0h-.09c-34.904-.014-69.202-8.768-99.665-25.381zm115.685-66.737 6.333 3.754c26.611 15.791 57.119 24.143 88.231 24.159h.068c95.544 0 173.308-77.745 173.348-173.297.014-46.307-17.997-89.849-50.727-122.602-32.731-32.753-76.251-50.802-122.556-50.821-95.62 0-173.381 77.734-173.419 173.283-.014 32.743 9.148 64.631 26.502 92.224l4.126 6.556-17.517 63.947z"/><path d="m47.936 455.541 28.565-104.301c-17.623-30.525-26.89-65.157-26.879-100.626.046-110.979 90.367-201.267 201.343-201.267 53.862.024 104.415 20.986 142.424 59.031 38.017 38.044 58.941 88.614 58.919 142.394-.046 110.982-90.373 201.278-201.335 201.278-.008 0 .005 0 0 0h-.09c-33.696-.011-66.805-8.469-96.212-24.496z" fill="url(#a)" filter="url(#shadow)"/><path d="m40.683 462.821 29.589-108.039c-18.25-31.619-27.851-67.489-27.838-104.236.046-114.958 93.602-208.485 208.566-208.485 55.789.024 108.153 21.738 147.533 61.145 39.375 39.41 61.05 91.795 61.031 147.508-.049 114.953-93.619 208.497-208.564 208.497-.008 0 .005 0 0 0h-.09c-34.904-.014-69.202-8.768-99.665-25.381zm115.685-66.737 6.333 3.754c26.611 15.791 57.119 24.143 88.231 24.159h.068c95.544 0 173.308-77.745 173.348-173.297.014-46.307-17.997-89.849-50.727-122.602-32.731-32.753-76.251-50.802-122.556-50.821-95.62 0-173.381 77.734-173.419 173.283-.014 32.743 9.148 64.631 26.502 92.224l4.126 6.556-17.517 63.947z" fill="url(#b)"/><path fill-rule="evenodd" fill="#fff" d="m198.873 163.387c-3.904-8.678-8.013-8.852-11.727-9.004-3.038-.13-6.515-.122-9.987-.122-3.475 0-9.121 1.306-13.896 6.52-4.778 5.215-18.242 17.821-18.242 43.46 0 25.642 18.676 50.417 21.279 53.897 2.606 3.475 36.052 57.771 89.021 78.659 44.022 17.359 52.98 13.907 62.535 13.038s30.832-12.604 35.175-24.773c4.343-12.167 4.343-22.596 3.04-24.776-1.303-2.172-4.778-3.475-9.99-6.081s-30.832-15.215-35.609-16.952c-4.778-1.737-8.252-2.606-11.727 2.611-3.475 5.212-13.456 16.947-16.496 20.422-3.04 3.483-6.081 3.917-11.293 1.311-5.212-2.614-21.996-8.111-41.907-25.864-15.492-13.812-25.951-30.87-28.991-36.087-3.04-5.212-.326-8.035 2.288-10.633 2.34-2.335 5.212-6.083 7.818-9.126 2.601-3.043 3.469-5.215 5.206-8.689 1.737-3.48.869-6.523-.434-9.129-1.301-2.605-11.429-28.377-16.063-38.682z" clip-rule="evenodd"/></svg>
    <?php } else { ?>
        <svg xmlns="http://www.w3.org/2000/svg"  alt="WhatsApp logo" viewbox="0 0 24 24" width="30px" height="30px"><path fill="#fff" d="M3.516 3.516c4.686-4.686 12.284-4.686 16.97 0 4.686 4.686 4.686 12.283 0 16.97a12.004 12.004 0 01-13.754 2.299l-5.814.735a.392.392 0 01-.438-.44l.748-5.788A12.002 12.002 0 013.517 3.517zm3.61 17.043l.3.158a9.846 9.846 0 0011.534-1.758c3.843-3.843 3.843-10.074 0-13.918-3.843-3.843-10.075-3.843-13.918 0a9.846 9.846 0 00-1.747 11.554l.16.303-.51 3.942a.196.196 0 00.219.22l3.961-.501zm6.534-7.003l-.933 1.164a9.843 9.843 0 01-3.497-3.495l1.166-.933a.792.792 0 00.23-.94L9.561 6.96a.793.793 0 00-.924-.445 1291.6 1291.6 0 00-2.023.524.797.797 0 00-.588.88 11.754 11.754 0 0010.005 10.005.797.797 0 00.88-.587l.525-2.023a.793.793 0 00-.445-.923L14.6 13.327a.792.792 0 00-.94.23z"/></svg>
    <?php } 
    if ( ! empty( $floating_label_text ) ) { ?>
    <div class="wayra-coc-floating-label">
        <div class="wayra-coc-floating-label-text"><?php echo $floating_label_text ?></div>
    </div>
    <?php } ?>
</a>