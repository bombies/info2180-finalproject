import {$get, $post, fetchSession, navigate, objectToFormData} from "../../utils.js";

(async () => {
    const session = await fetchSession()
    if (!session)
        navigate('/')
})();

(async () => {
    const select = document.getElementById('assignedToSelect')
    if (!select)
        return

    const users = await $get('/api/users/users.php')
        .then(res => res.json())
        .catch(e => {
            console.error(e)
            return undefined
        })

    users?.forEach(user => {
        const userOption = document.createElement('option')
        userOption.value = user.id
        userOption.id = user.id
        userOption.innerText = `${user.firstname} ${user.lastname}`
        userOption.style.textTransform = 'capitalize'

        select.appendChild(userOption)
    })
})();

(() => {
    const form = document.getElementById('new-contact-form')
    if (!form)
        return

    const titleInput = document.getElementById('title')
    const firstNameInput = document.getElementById('firstname')
    const lastNameInput = document.getElementById('lastname')
    const emailInput = document.getElementById('email')
    const telephoneInput = document.getElementById('telephone')
    const companyInput = document.getElementById('company')
    const typeSelect = document.getElementById('type')
    const assignedToSelect = document.getElementById('assignedToSelect')
    form.addEventListener('submit', async (event) => {
        event.preventDefault()

        const title = titleInput.value
        const firstname = firstNameInput.value
        const lastname = lastNameInput.value
        const email = emailInput.value
        const telephone = telephoneInput.value
        const company = companyInput.value
        const type = typeSelect.value
        const assigned_to = assignedToSelect.value

        const res = await $post('/api/contact/createcontact.php', objectToFormData({
            title,
            firstname,
            lastname,
            email,
            telephone,
            company,
            type,
            assigned_to
        }))
            .then(res => res.json())
            .catch(e => {
                console.error(e)
                return undefined
            })

        if (res?.success) {
            navigate('/dashboard')
        } else {
            alert("Something went wrong!")
        }
    })
})();