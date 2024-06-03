import del from 'del'

export const reset = () => {
    return del(app.path.clean)
}

export const reset_set = () => {
    return del(app.path.clean_set)
}