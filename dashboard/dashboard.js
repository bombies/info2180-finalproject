import {fetchSession, navigate} from "../utils.js";

(async () => {
    const session = await fetchSession()
    if (!session)
        navigate('/')
})();


let selectedFilter = 'all';

const generateChip = (text, color) => {
    const chip = document.createElement('div')
    chip.classList.add('chip')
    chip.style.backgroundColor = color
    chip.innerText = text
    return chip
}


(() => {
    const buttons = document.querySelectorAll('.dash-container-filter-bar .underlined-btn')
    buttons.forEach(button => {
        if (button.id === selectedFilter)
            button.classList.add('active')

        button.addEventListener('click', () => {
            buttons.forEach(button => button.classList.remove('active'))
            button.classList.add('active')
            selectedFilter = button.id
        })
    })
})();

(() => {
    const tableBody = document.getElementById("user-table-body");
    const users = [{
        name: 'John Doe',
        email: 'john.doe@gmail.com',
        company: 'KFC',
        status: 'Support'
    }] // TODO: get users from server

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
            const companyCell = document.createElement('td')
            const typeCell = document.createElement('td')
            const actionCell = document.createElement('td')
            const actionButton = document.createElement('a')

            nameCell.innerText = user.name
            emailCell.innerText = user.email
            companyCell.innerText = user.company

            typeCell.appendChild(generateChip(user.status, user.status === 'Support' ? '#FFC107' : '#4CAF50'))

            const loc = window.location.pathname.replace("http://", '')
            const url = loc.substring(0, loc.indexOf("/", 1)) + "/dashboard/"
            actionButton.innerText = 'View'
            actionButton.href = url
            actionCell.appendChild(actionButton)

            row.appendChild(nameCell)
            row.appendChild(emailCell)
            row.appendChild(companyCell)
            row.appendChild(typeCell)
            row.appendChild(actionCell)
            tableBody.appendChild(row)
        })
    }
})();