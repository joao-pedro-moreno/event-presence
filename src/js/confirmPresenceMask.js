const cpfInput = document.querySelector("#confirm-cpf");

const cpfPattern = {
    mask: "000.000.000-00",
}

const cpfInputMasked = IMask(cpfInput, cpfPattern);

const telInput = document.querySelector("#confirm-tel");

const telPattern = {
    mask: "(00) 00000-0000",
}

const telInputMasked = IMask(telInput, telPattern);