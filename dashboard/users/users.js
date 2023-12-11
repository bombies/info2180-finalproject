import {$get, fetchSession, navigate} from "../../utils.js";

(async () => {
    const session = await fetchSession()
    if (!session)
        navigate('/')
})();

(async () => {
    const tableBody = document.getElementById("users-table-body");
    if (!tableBody)
        return;

    const users = await $get("/api/users/users.php")
        .then(res => res.json())
        .catch(e => {
            console.error(e)
            return undefined
        })

    if (!users || !users.length) {
        const row = document.createElement('tr')
        const cell = document.createElement('td')

        cell.style.textAlign = 'center'
        cell.style.fontWeight = '500'
        cell.style.color = '#1A1A1A20'
        cell.style.fontSize = '32px'

        cell.innerText = 'No users found'
        cell.colSpan = 5

        row.appendChild(cell)
        tableBody.appendChild(row)
    } else {
        users.forEach(user => {
            const row = document.createElement('tr')
            const nameCell = document.createElement('td')
            const emailCell = document.createElement('td')
            const createdCell = document.createElement('td')
            const roleCell = document.createElement('td')

            nameCell.innerText = `${user.firstname} ${user.lastname}`
            nameCell.style.fontWeight = '600'
            nameCell.style.textTransform = 'capitalize'

            emailCell.innerText = user.email
            emailCell.style.color = '#1A1A1A80'

            roleCell.innerText = user.role
            roleCell.style.color = '#1A1A1A80'

            createdCell.innerText = new Date(user.created_at).toLocaleString("en", {
                dateStyle: "short",
                timeStyle: "short",
            })
            createdCell.style.color = '#1A1A1A80'

            row.appendChild(nameCell)
            row.appendChild(emailCell)
            row.appendChild(roleCell)
            row.appendChild(createdCell)

            tableBody.appendChild(row)
        })
    }
})()