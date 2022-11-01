const notifySection = document.querySelector(".notify-section")

function createNotify(type, message, time) {
    const notify = `
        <section class="${type}-notify notify">
            <i class='bx ${notifyIcon(type)}'></i>
            <div class="notify-content">
                <span class="notify-title">${type}</span>
                <p class="notify-message">${message}</p>
            </div>
        </section>
    `

    notifySection.innerHTML = notify
    
    if (time == "" || time == undefined || time == null) {
        setTimeout(function (){
            const notifyElement = document.querySelector(".notify").remove()
        }, 7000)
    } else {
        setTimeout(function (){
            const notifyElement = document.querySelector(".notify").remove()            
        }, time * 1000)
    }
}

function notifyIcon(type) {
    if (type == "error") {
        return "bx-x-circle"
    } else if (type == "success") {
        return "bx-check-circle"
    }
}