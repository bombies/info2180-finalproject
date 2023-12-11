import {$post, fetchSession, navigate, objectToFormData} from './utils.js';

(async () => {
    console.log('test')
    const session = await fetchSession();
    if (session)
        return navigate("/dashboard/index.html");
})();

(() => {
    const form = document.getElementById("login-form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const error = document.getElementById("error");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        try {
            await $post("/api/auth/login.php", objectToFormData({
                email: email.value,
                password: password.value
            }))
            navigate("/dashboard/index.html");
        } catch (err) {
            error.innerText = err;
        }
    });
})();