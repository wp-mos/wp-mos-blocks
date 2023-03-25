<?php

    function mos_order_form() {
        ob_start();
        ?>
        <div class="wp-block-mos-blocks-order-form">
            <form id="mos-order-form" class="mos-order-form" enctype="multipart/form-data" method="post">

                <div class="order-form-group" data-id="0">

                    <div class="order-form-block order-form-block-file">
                        <div class="order-form-label">Fișier</div>
                        <label class="form-subscribe-button form-subscribe-button-secondary" for="order-form-file-0">
                            DXF File
                        </label>
                        <input type="file" id="order-form-file-0" class="order-form-file" name="file-0" required>
                    </div>

                    <div class="order-form-block order-form-block-35">
                        <label class="order-form-label" for="material-0">Material</label>
                        <select class="order-form-material order-form-select" name="material-0" required>
                            <option>Choose file</option>
                        </select>
                    </div>

                    <div class="order-form-block order-form-block-10">
                        <label class="order-form-label" for="quantity-0">Cantitate</label>
                        <input type="number" class="order-form-quantity order-form-input" name="quantity-0" min="1"
                               required max="100" value="1">
                    </div>

                    <div class="order-form-block-status order-form-block-20">
                        <div class="order-form-sub-block">
                            <div class="order-form-label">Dimensiuni</div>
                            <div class="order-form-dimensions">-</div>
                        </div>
                        <div class="order-form-sub-block">
                            <div class="order-form-label">Pret</div>
                            <div class="order-form-status">-</div>
                        </div>

                    </div>

                    <!-- <div class="order-form-close">
                      <button type="button" class="order-form-close-button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 18L18 6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                          <path d="M18 18L6 6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </button>
                    </div> -->

                </div>

                <div class="order-form-add-group">
                    <button type="button" id="order-form-add"
                            class="form-subscribe-button form-subscribe-button-secondary" data-id="0">Adaugă un fișier
                    </button>
                    <div class="small-text">Fișiere permise: dxf</div>
                    <div class="small-text">Dimensiunea maximă: 50Mb</div>
                </div>

                <div class="order-form-checkout">
                    <div id="order-form-total-price"></div>
                    <button id="mos-submit-form" class="form-subscribe-button" type="submit">Comandă acum</button>
                </div>

            </form>


        </div>
        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
