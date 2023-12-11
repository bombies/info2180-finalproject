import {$post, fetchSession, navigate, objectToFormData} from "../../../utils.js";

(async () => {
    const session = await fetchSession()
    if (!session)
        navigate('/')
    else if (session.role === 'Admin')
        navigate('/dashboard')
})();

(() => {
    const form = document.getElementById('registration-form')
    if (!form)
        return;

    const firstNameInput = document.getElementById('first_name')
    const lastNameInput = document.getElementById('last_name')
    const emailInput = document.getElementById('email')
    const passwordInput = document.getElementById('password')
    const roleSelect = document.getElementById('role')
    const errorDiv = document.getElementById('error')
    const PASSWORD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/

    form.addEventListener('submit', async (event) => {
        event.preventDefault()

        if (!PASSWORD_REGEX.test(passwordInput.value)) {
            errorDiv.innerText = 'Password must be at least 8 characters long with at least one uppercase letter and one number'
            return;
        }

        const body = {
            email: emailInput.value,
            password: passwordInput.value,
            firstname: firstNameInput.value,
            lastname: lastNameInput.value,
            role: roleSelect.value
        }

        const user = await $post('/api/auth/register.php', objectToFormData(body))
            .then(res => res.json())
            .catch(e => {
                console.error(e)
                return undefined
            })

        if (!user || !user.success) {
            return alert('Failed to add user')
        } else {
            navigate('/dashboard/users')
        }
    })
})();