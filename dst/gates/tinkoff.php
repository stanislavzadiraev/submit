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
            
            '<input id="receipt" type="hidden" name="receipt" value="">'.
            '<input id="amount" type="hidden" name="amount" value="">'.

            '<button type="submit" name="submit">Оплатить</button>'.
        '</form>'.
        '<script>
            const label = "item"
            const value = "price"
            document
                .querySelector("div#pay-tinkoff>form")
                .addEventListener("submit", e => (
                    e.preventDefault(e),
                    document
                        .querySelector("div#pay-tinkoff>form")
                        .receipt.value = JSON.stringify({
                            "EmailCompany": "mail@mail.com",
                            "Taxation": "patent",
                            "FfdVersion": "1.2",
                            "Items": [
                                {
                                    "Name": label,
                                    "Price": value * 100,
                                    "Quantity": 1.00,
                                    "Amount": value * 100,
                                    "PaymentMethod": "full_prepayment",
                                    "PaymentObject": "service",
                                    "Tax": "none",
                                    "MeasurementUnit": "pc"
                                }
                            ]
                        }),
                    pay(document.querySelector("div#pay-tinkoff>form"))
                ))
        </script>'.
        '</div>';
}

?>