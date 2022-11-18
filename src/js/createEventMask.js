const telInput = document.querySelector("#event-tel");

const telPattern = {
    mask: "(00) 00000-0000",
}

const telInputMasked = IMask(telInput, telPattern);

const hourStartInput = document.querySelector("#event-hour-start");

const hourStartPattern = {
    mask: "00:00",
}

const hourStartInputMasked = IMask(hourStartInput, hourStartPattern)

const hourEndInput = document.querySelector("#event-hour-end");

const hourEndPattern = {
    mask: "00:00",
}


const hourEndInputMasked = IMask(hourEndInput, hourEndPattern)
