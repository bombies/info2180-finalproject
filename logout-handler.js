import {$post, navigate} from "./utils.js";

(() => {
    const logoutButton = document.querySelector('.logout-button');
    if (!logoutButton)
        return;

    logoutButton.addEventListener('click', () => {
        $post('/api/auth/logout.php')
            .then(() => navigate("/"))
            .catch(e => console.error(e))
    })
})()