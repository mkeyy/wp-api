<?php   
    
    $slug = '';

    if(defined('ICL_LANGUAGE_CODE')) {
        $slug = '-' . ICL_LANGUAGE_CODE;
    }
    
    $cookie_main_heading_opt = 'cookie_main_heading' . $slug;
    $cookie_main_content_opt = 'cookie_main_content' . $slug;
    $cookie_widget_text_opt = 'cookie_widget_text' . $slug;
    $cookie_widget_href_opt = 'cookie_widget_href' . $slug;
    $cookie_widget_close_opt = 'cookie_widget_close' . $slug;
        
    if($_POST['cookie_hidden'] == 'Y') {  
        
        $cookie_main_heading = $_POST[$cookie_main_heading_opt];  
        update_option($cookie_main_heading_opt, $cookie_main_heading); 

        $cookie_main_content = $_POST[$cookie_main_content_opt];  
        update_option($cookie_main_content_opt, $cookie_main_content);

        $cookie_widget_text = $_POST[$cookie_widget_text_opt];  
        update_option($cookie_widget_text_opt, $cookie_widget_text);

        $cookie_widget_href = $_POST[$cookie_widget_href_opt];  
        update_option($cookie_widget_href_opt, $cookie_widget_href);

        $cookie_widget_close = $_POST[$cookie_widget_close_opt];  
        update_option($cookie_widget_close_opt, $cookie_widget_close);
            
        ?>  
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php  
    } else {  
        $cookie_main_heading = get_option($cookie_main_heading_opt);
        $cookie_main_content = get_option($cookie_main_content_opt);
        $cookie_widget_text = get_option($cookie_widget_text_opt);
        $cookie_widget_href = get_option($cookie_widget_href_opt);
        $cookie_widget_close = get_option($cookie_widget_close_opt);
    }  
?>  
        
<div class="wrap">  
    <?php    echo "<h2>" . __( 'Ustawienia Cookies', 'cookie_options' ) . "</h2>"; ?>  
      
    <form name="cookie_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        
        <input type="hidden" name="cookie_hidden" value="Y">
        
        <h4>Nagłówek regulaminu</h4>
        <div id="titlediv">
            <div id="titlewrap">
                <input type="text" name="<?php echo $cookie_main_heading_opt;?>" size="30" value="<?php echo $cookie_main_heading; ?>" id="title" autocomplete="off">
            </div>
        </div>
        <h4>Treść regulaminu</h4>
        <?php 
            wp_editor($cookie_main_content, $cookie_main_content_opt);
        ?>
        
        <h4>Treść chmurki</h4>
        <textarea style="width:100%; height:100px;" name="<?php echo $cookie_widget_text_opt;?>"><?php echo $cookie_widget_text; ?></textarea><br/>
        
        <h4>Link do regulaminu</h4>
        <input type="text" name="<?php echo $cookie_widget_href_opt;?>" size="30" value="<?php echo $cookie_widget_href; ?>" id="title" autocomplete="off">
        
        <h4>Przycisk zamknij</h4>
        <input type="text" name="<?php echo $cookie_widget_close_opt;?>" size="30" value="<?php echo $cookie_widget_close; ?>" id="title" autocomplete="off">
        
        <p class="submit">  
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'cookie' ) ?>" />  
        </p>  
        
    </form>  
    
</div>