<?php

return function($form){
    return 
        $form.
        '<div id="pay-tinkoff">'.
        '<script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>'.
        '<form id="payform-tbank" name="pay-tinkoff" >'.
            '<input type="hidden" name="terminalkey" value="1698927993527">'.
            '<input type="hidden" name="frame" value="false">'.
            '<input type="hidden" name="language" value="ru">'.

            '<button type="submit" name="submit" class="button" text="Оплатить">Оплатить</button>'.
        '</form>'.
        '<script>
            document
                .getElementById("payform-tbank")
                .addEventListener("submit", e => (
                    preventDefault(e)
                ))
        </script>'.
        '</div>';
}

?>