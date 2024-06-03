<?php // Шорткод вывода шагов
function casino_filter(){
    if(!is_admin()):
        global $translations_page;

        $casFilter = get_option('casino_filters');
        $currency = get_option('currency');
        
        $count = count(array_keys($casFilter));
        $currency_alert = '';
        if(isset($translations_page['currency_alert']) && !empty($translations_page['currency_alert'])){
            $currency_alert .= "<p class='text-center currency_alert'>".$translations_page['currency_alert']."</p>";
            $currency = '';
        }

        if(isset($casFilter['min_deposit']) && 
        !empty($casFilter['min_deposit'])  && 
        isset($casFilter['max_deposit']) && 
        !empty($casFilter['max_deposit'])){
            $count--;
        }
        $count++;
        $out = '';
        if( 
            isset($casFilter['payment_methods']) && !empty($casFilter['payment_methods']) ||
            isset($casFilter['bonus_on_top']) && !empty($casFilter['bonus_on_top']) ||
            isset($casFilter['games_types']) && !empty($casFilter['games_types']) ||
            isset($casFilter['min_deposit']) && 
            !empty($casFilter['min_deposit']) && 
            isset($casFilter['max_deposit']) && 
            !empty($casFilter['max_deposit'])
        ) {

        $out = "<form method='get' class='casinoFilter d-flex flex-column js-casinoFilter' data-currency='".$currency."'>
            <div class='d-flex col-12 align-items-center extendTitle-title'>
                <h2 class='title-line js-casinoFilterTitle'>".$translations_page[array_keys($casFilter)[0]]."</h2>
                <div class='extendTitle-content extendTitle-content-title'><span class='extendTitle-content-title'>Step <span class='js-filterStepsCounter'>1</span></span> of ".$count."</div>
            </div>
            <div class='js-casinoFilterBlocks filter_preloader js-filterPreloader'>
        ";
        
        if(isset($casFilter['payment_methods']) && !empty($casFilter['payment_methods'])){
            $out .= "<div class='casinoFilter-payment_methods' data-title='".$translations_page['payment_methods']."'>
                <div class='casinoFilter-block d-flex flex-wrap'>";
                foreach($casFilter['payment_methods'] as $key => $payment_method){
                    if(!in_array('', $payment_method, true)){
                        $out .= "<label class='d-flex align-items-center'>
                                <input type='checkbox' class='d-none' name='payment-method[$key]' value='".$payment_method['value']."' />
                                <div class='checkbox-container'></div>
                                <div class='casinoFilter-payment_methods-img d-flex align-items-center'>".
                                    wp_get_attachment_image( $payment_method['img'], 'full' )
                                ."</div>
                            </label>";
                    }
                }
            $out .= "</div></div>";
        }
        
        if(isset($casFilter['bonus_on_top']) && !empty($casFilter['bonus_on_top'])){
            $out .= "<div class='casinoFilter-bonus_on_top d-flex flex-wrap' data-title='".$translations_page['bonus']."'>
            <div class='casinoFilter-block d-flex flex-wrap'>";
            foreach($casFilter['bonus_on_top'] as $key => $payment_method){
                if(!in_array('', $payment_method, true)){
                    $out .= "<label class='d-block'>
                            <div class='casinoFilter-bonus_on_top d-flex justify-content-center'>".
                                wp_get_attachment_image( $payment_method['img'], 'full' )
                            ."</div>
                            <input type='checkbox' class='d-none' name='bonus_on_top[$key]' value='".$payment_method['value']."' /> 
                            <div class='d-flex justify-content-center'>
                                <div class='checkbox-container'></div>
                                <p>".$translations_page[$payment_method['value']]."</p>
                            </div>                            
                        </label>";
                }
            }
            $out .= "</div></div>";
        }
        
        if(isset($casFilter['games_types']) && !empty($casFilter['games_types'])){
            $out .= "<div class='casinoFilter-bonus_on_top d-flex flex-wrap' data-title='".$translations_page['game_types']."'>
            <div class='casinoFilter-block d-flex flex-wrap'>";
            foreach($casFilter['games_types'] as $key => $payment_method){
                if(!in_array('', $payment_method, true)){
                    $out .= "<label class='d-block'>
                            <div class='casinoFilter-bonus_on_top d-flex justify-content-center'>".
                                wp_get_attachment_image( $payment_method['img'], 'full' )
                            ."</div>
                            <input type='checkbox' class='d-none' name='games_types[$key]' value='".$payment_method['value']."' /> 
                            <div class='d-flex justify-content-center'>
                                <div class='checkbox-container'></div>
                                <p>".$translations_page[$payment_method['value']]."</p>
                            </div>                            
                        </label>";
                }
            }
            $out .= "</div></div>";
        }

        if(isset($casFilter['min_deposit']) && 
            !empty($casFilter['min_deposit'])  && 
            isset($casFilter['max_deposit']) && 
            !empty($casFilter['max_deposit'])
        ){
            $out .= "
            <div class='js-sliderContainer' data-max='".$casFilter['max_deposit'][0]['value']."' data-min='".$casFilter['min_deposit'][0]['value']."' data-title='".$translations_page['min_deposit']." / ".$translations_page['max_deposit']."'>
            <div class='casinoFilter-block d-flex flex-wrap'>
                $currency_alert
                    <div class='slider-container'>
                        <div class='slider'></div>
                        <div class='slider-inputs d-flex align-items-end'>
                            <div class='slider-inputs-wrap'>
                                <p>".$translations_page['min_deposit']."</p>                            
                                <div class='input-currency'>
                                    <input type='text' name='min_deposit' class='formatting-start'>
                                    <span class='currency text-center'>".$currency."</span>
                                </div>
                            </div>
                            <div class='slider-inputs-separ'></div>
                            <div class='slider-inputs-wrap'>
                                <p>".$translations_page['max_deposit']."</p>                            
                                <div class='input-currency'>
                                    <input type='text' name='max_deposit' class='formatting-end'>
                                    <span class='currency text-center'>".$currency."</span>
                                </div>
                            </div>
                        </div>                
                    </div>
            ";
            $out .= "</div></div>";
        }        
        $out .= "
            <div class='casinoFilter-block casinoFilter-result js-casinoFilterResult' data-title='Result'></div>
            </div>
            <div class='casinoFilter-controls js-casinoFilterControls d-flex align-items-center justify-content-center'>
                <span class='js-casinoFilter-controlsPrev casinoFilter-controls-prev disable'>".$translations_page['previous_step']."</span>
                <span class='js-casinoFilter-controlsNext btn btn-js'>".$translations_page['next_step']."</span>
                <span class='js-casinoFilter-controlsReset casinoFilter-controlsReset btn btn-js'>".$translations_page['start_step']."</span>
            </div>
            </form>
        ";
        }
    return $out;

    endif;
}

add_shortcode( 'casino_filter', 'casino_filter' );                              // Шорткод вывода шагов