<?php
    $meta_keys = array('image_desktop','image_mobile'); //Choix du nombre d'images qui seront uploadées ainsi que leur nom de class

    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
        <div class="custom_postimage_wrapper" id="<?php echo $meta_key; ?>_wrapper" style="margin-bottom:20px;">
		<?php if($meta_key == 'image_desktop'){?>
			<p style="color:grey">Sélectionnez l'image pour l'affichage sur ordinateur<strong style="color:red">*</strong></p>
		<?php }else if($meta_key == 'image_mobile'){?>
			<p style="color:grey">Sélectionnez l'image pour l'affichage sur mobile</p>
		<?php } ?>
            <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val,'default')[0]:''); ?>" style="display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt="">
            <a class="addimage button" onclick="custom_postimage_add_image('<?php echo $meta_key; ?>');"><?php _e('Ajouter/modifier une image','regie_publicitaire'); ?></a><br>
            <a class="removeimage" style="color:#a00;cursor:pointer;display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="custom_postimage_remove_image('<?php echo $meta_key; ?>');"><?php _e('Supprimer l\'image','yourdomain'); ?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
        </div>
    <?php } ?>
    <script>
    function custom_postimage_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Choisir une image','regie_publicitaire'); ?>',
            button: {
                text: '<?php _e('Sélectionner cette image','regie_publicitaire'); ?>'
            },
            multiple: false
        });
        custom_postimage_uploader.on('select', function() {

            var attachment = custom_postimage_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
			$wrapper.find('.addimage.button').hide();
            $wrapper.find('a.removeimage').show();
        });
        custom_postimage_uploader.on('open', function(){
            var selection = custom_postimage_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_postimage_uploader.open();
        return false;
    }

    function custom_postimage_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
		$wrapper.find('.addimage.button').show();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
    <?php
    wp_nonce_field( 'adtest_metabox_imgmobile', 'custom_postimage_meta_box_nonce' );