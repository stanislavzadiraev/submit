<?php

return function($form){
    return 
        $form.
        '<div id="pay-tinkoff">'.
        '<script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>'.
        '<form name="pay-tinkoff" >'.
            '<input type="hidden" name="terminalkey" value="1698927993527">'.
            '<input type="hidden" name="frame" value="false">'.
            '<input type="hidden" name="language" value="ru">'.

            '<button type="submit" name="submit" class="button" text="Оплатить">Оплатить</button>'.
        '</form>'.
        '<script>
            document
                .querySelector("div#pay-tinkoff>form")
                .addEventListener("submit", e => (
                    e.preventDefault(e)
                ))
        </script>'.
        '</div>';
}

?>