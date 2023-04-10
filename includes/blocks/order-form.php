<?php

    function mos_order_form() {
        ob_start();
        ?>
        <div class="wp-block-mos-blocks-order-form">
            <form id="mos-order-form" class="mos-order-form" enctype="multipart/form-data" method="post">

                <div class="order-form-group" data-id="0">

                    <div class="order-form-block order-form-block-file">
                        <div class="order-form-label"><?php _e( 'File', 'mos' ) ?></div>
                        <label class="form-subscribe-button form-subscribe-button-secondary" for="order-form-file-0">
                            <?php _e( 'DXF File', 'mos' ) ?>
                        </label>
                        <input type="file" id="order-form-file-0" class="order-form-file" name="file-0" required>
                    </div>

                    <div class="order-form-block order-form-block-35">
                        <label class="order-form-label" for="material-0">
                            <?php _e( 'Material', 'mos' ) ?>

                        </label>
                        <select class="order-form-material order-form-select" name="material-0" required>
                            <option>
                                <?php _e( 'Choose file', 'mos' ) ?>
                            </option>
                        </select>
                    </div>

                    <div class="order-form-block order-form-block-10">
                        <label class="order-form-label" for="quantity-0">
                            <?php _e( 'Quantity', 'mos' ) ?>
                        </label>
                        <input type="number" class="order-form-quantity order-form-input" name="quantity-0" min="1"
                               required max="100" value="1">
                    </div>

                    <div class="order-form-block-status order-form-block-20">
                        <div class="order-form-sub-block">
                            <div class="order-form-label">
                                <?php _e( 'Dimensions', 'mos' ) ?>
                            </div>
                            <div class="order-form-dimensions">-</div>
                        </div>
                        <div class="order-form-sub-block">
                            <div class="order-form-label">
                                <?php _e( 'Price', 'mos' ) ?>
                            </div>
                            <div class="order-form-status">-</div>
                        </div>

                    </div>

                </div>

                <div class="order-form-add-group">
                    <button type="button" id="order-form-add"
                            class="form-subscribe-button form-subscribe-button-secondary order-form-add"
                            data-id="0">
                        <?php _e( 'Add a file', 'mos' ) ?>
                    </button>
                    <div class="small-text">
                        <?php _e( 'Allowed Files: dxf', 'mos' ) ?>
                    </div>
                    <div class="small-text">
                        <?php _e( 'Max file size: 50Mb', 'mos' ) ?>
                    </div>
                </div>

                <div class="order-form-checkout">
                    <div id="order-form-total-price"></div>
                    <button id="mos-submit-form" class="form-subscribe-button" type="submit">
                        <?php _e( 'Order Now', 'mos' ) ?>
                    </button>
                </div>

            </form>


        </div>
        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
