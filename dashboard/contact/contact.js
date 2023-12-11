import {$post, fetchSession, navigate, objectToFormData} from "../../utils.js";

(async () => {
    const session = await fetchSession()
    if (!session)
        navigate('/')
})();

const searchParams = new URLSearchParams(window.location.search);

(() => {
    const noteForm = document.getElementById('note-form')
    if (!noteForm)
        return;

    const noteInput = document.getElementById('note-textarea')
    noteForm.addEventListener('submit', async (e) => {
        e.preventDefault()

        const body = {
            content: noteInput.value,
            contact_id: searchParams.get('id')
        }

        const note = await $post('/api/notes/addnote.php', objectToFormData(body))
            .then(res => res.json())
            .catch(e => {
                console.error(e)
                return undefined
            })

        if (!note) {
            alert('Failed to add note')
            return
        }

        const notesContainer = document.getElementById('notes-container')
        const noteContainer = document.createElement('div')
        const noteCreator = document.createElement('h6')
        const noteText = document.createElement('p')
        const noteCreatedAt = document.createElement('p')
        noteContainer.classList.add("note")

        noteCreator.innerText = `${note.firstname} ${note.lastname}`
        noteCreator.style.textTransform = 'capitalize'
        noteCreator.classList.add("mini-heading")
        noteText.innerText = note.content
        noteCreatedAt.innerText = new Date(note.created_at).toLocaleString("en", {
            dateStyle: 'long',
            timeStyle: 'short'
        })
        noteCreatedAt.classList.add("subtitle")

        noteContainer.append(noteCreator, noteText, noteCreatedAt)
        notesContainer.append(noteContainer)
    });
})();

(() => {
    const assignedToSelfButton = document.getElementById("assign-to-self-btn")
    if (!assignedToSelfButton)
        return;

    assignedToSelfButton.addEventListener('click', async () => {
        const id = searchParams.get("id")
        const res = await $post(
            '/api/contact/assignself.php',
            objectToFormData({contact_id: id})
        )
            .then(res => res.json())
            .catch(e => {
                console.error(e)
                return undefined
            })

        if (!res) {
            alert('Failed to assign to self')
        } else {
            window.location.reload()
        }
    })
})();

(() => {
    const switchTypeButton = document.getElementById("switch-btn")
    if (!switchTypeButton)
        return;

    switchTypeButton.addEventListener('click', async () => {
const id = searchParams.get("id")
        const res = await $post(
            '/api/contact/switchtype.php',
            objectToFormData({contact_id: id})
        )
            .then(res => res.json())
            .catch(e => {
                console.error(e)
                return undefined
            })

        if (!res || !res.success) {
            alert('Failed to switch type')
        } else {
            window.location.reload()
        }
    })
})()