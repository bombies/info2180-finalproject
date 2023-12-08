import {$post, fetchSession, navigate, objectToFormData} from './utils.js';

(async () => {
    const session = await fetchSession();
    if (session)
        return navigate("/dashboard/index.html");
})();

(async () => {
    const form = document.getElementById("login-form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const error = document.getElementById("error");

    const PASSWORD_REGEX = /^[a-zA-Z\d]{8,}$/

    if (!PASSWORD_REGEX.test(password.value)) {
        error.innerText = "Password must be at least 8 characters long at least 1 letter and 1 number"
        return;
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        try {
            await $post("/api/auth/login.php", objectToFormData({
                email: email.value,
                password: password.value
            }))
            navigate("/dashboard/index.html");
        } catch (e) {
            error.innerText = e;

        }
    });
})();