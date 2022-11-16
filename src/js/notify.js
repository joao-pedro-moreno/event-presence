const notifySection = document.querySelector(".notify-section");

const createNotify = (type, message, time) => {
    const notify = `
        <section class="${type}-notify notify">
            <i class='bx ${type === 'error' ? 'bx-x-circle' : 'bx-check-circle'}'></i>
            <div class="notify-content">
                <span class="notify-title">${type}</span>
                <p class="notify-message">${message}</p>
            </div>
        </section>
    `;

    notifySection.innerHTML = notify;

    setTimeout(() => {
        document.querySelector(".notify").remove();
    }, time * 1000 || 7000);
};