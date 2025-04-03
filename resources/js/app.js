import './bootstrap';
import Inputmask from 'inputmask';

if (document.baseURI.includes('customers')) {
    document.addEventListener("DOMContentLoaded", function() {
        Inputmask({
            mask: ["999.999.999-99", "99.999.999/9999-99"],
            keepStatic: true
        }).mask(document.getElementById("cpf_cnpj"));
    
        Inputmask({
            mask: ["(99) 99999-9999", "(99) 9999-9999"],
            keepStatic: true
        }).mask(document.getElementById("phone"));
    });
}

if (document.baseURI.includes('sales')) {
    document.addEventListener("DOMContentLoaded", function() {
        Inputmask({
            alias: "numeric",
            prefix: "R$ ",
            groupSeparator: ".",
            radixPoint: ",",
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            rightAlign: false,
            allowMinus: false,
        }).mask(document.getElementById("price"));
    });
}