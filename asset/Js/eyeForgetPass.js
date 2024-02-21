    const showIconNew = document.querySelector("#showIconNew");
    const hideIconNew = document.querySelector("#hideIconNew");
    const passwordFieldNew = document.querySelector("#new-password");

    showIconNew.addEventListener("click", () => {
        showIconNew.style.display = "none";
        hideIconNew.style.display = "inline-block";
        passwordFieldNew.type = "text";
    });

    hideIconNew.addEventListener("click", () => {
        hideIconNew.style.display = "none";
        showIconNew.style.display = "inline-block";
        passwordFieldNew.type = "password";
    });

    const showIconConfirm = document.querySelector("#showIconConfirm");
    const hideIconConfirm = document.querySelector("#hideIconConfirm");
    const passwordFieldConfirm = document.querySelector("#confirm-new-password");

    showIconConfirm.addEventListener("click", () => {
        showIconConfirm.style.display = "none";
        hideIconConfirm.style.display = "inline-block";
        passwordFieldConfirm.type = "text";
    });

    hideIconConfirm.addEventListener("click", () => {
        hideIconConfirm.style.display = "none";
        showIconConfirm.style.display = "inline-block";
        passwordFieldConfirm.type = "password";
    });
