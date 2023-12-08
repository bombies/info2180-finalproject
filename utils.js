export const navigate = (path) => {
    const loc = window.location.pathname.replace("http://", '')
    const url = loc.substring(0, loc.indexOf("/", 1)) + path
    const aTag = document.createElement("a")
    aTag.href = url
    aTag.click()
    aTag.remove()
}

export const fetchSession = () => $get("/api/auth/session.php")
    .then(res => res.json())
    .catch(e => {
        console.error(e)
        return undefined
    })

export const $get = (url) => {
    const loc = window.location.pathname.replace("http://", '')
    return fetch(loc.substring(0, loc.indexOf("/", 1)) + url)
}

export const $post = (url, body) => {
    const loc = window.location.pathname.replace("http://", '')
    return fetch(loc.substring(0, loc.indexOf("/", 1)) + url, {
        method: "POST",
        body: body
    })
        .then(res => {
            if (!res.ok)
                return Promise.reject(res.statusText)
            return res
        })
}

export const objectToFormData = (obj) => {
    const formData = new FormData()
    Object.keys(obj).forEach(key => formData.append(key, obj[key]))
    return formData
}