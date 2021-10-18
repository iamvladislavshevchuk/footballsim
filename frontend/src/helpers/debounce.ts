export default function debounce<T extends Function>(func: T, wait = 300) {
    let timeout: NodeJS.Timeout

    return function executedFunction(...args: any) {
        const later = () => {
            clearTimeout(timeout)
            func(...args)
        }

        clearTimeout(timeout)
        timeout = setTimeout(later, wait)
    }
}