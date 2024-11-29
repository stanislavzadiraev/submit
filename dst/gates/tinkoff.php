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
            '<input id="amount" type="hidden" name="amount" value="100">'.

            '<input id="email" type="hidden" name="email" value="">'.
            '<input id="phone" type="hidden" name="phone" value="">'.

            '<button type="submit" name="submit">Оплатить</button>'.
        '</form>'.
        '<script>
            document
                .querySelector("div#pay-tinkoff>form")
                .addEventListener("submit", e => (
                    e.preventDefault(e),
                    
                    document
                        .querySelector("div#pay-tinkoff>form")
                        .email.value = 
                            document
                                .querySelector("div#fin-email>span.email").innerHTML,

                    document
                        .querySelector("div#pay-tinkoff>form")
                        .phone.value = 
                            document
                                .querySelector("div#fin-phone>span.phone").innerHTML,

                    document
                        .querySelector("div#pay-tinkoff>form")
                        .amount.value = 
                            document
                                .querySelector("div#fin-total>span.total").innerHTML,                    

                    document
                        .querySelector("div#pay-tinkoff>form")
                        .receipt.value = JSON.stringify({
                            "EmailCompany": "mail@mail.com",
                            "Taxation": "patent",
                            "Items": 
                                Array.from(
                                    document
                                        .querySelectorAll("div[name][cost]")
                                )
                                .map(e => ({
                                    name: e.attributes.name.value,
                                    cost: e.attributes.cost.value
                                }))
                                .filter(e => e.cost)
                                .map(({name, cost}) => ({
                                    "Name": name,
                                    "Price": cost * 100,
                                    "Quantity": 1,
                                    "Amount": cost * 100,
                                    "PaymentMethod": "full_prepayment",
                                    "PaymentObject": "service",
                                    "Tax": "none",
                                    "MeasurementUnit": "pc"
                                }))

                        }),
                    pay(document.querySelector("div#pay-tinkoff>form"))
                ))
        </script>'.
        '</div>';
}

?>