import { Link } from "react-router-dom"
import "./Button.scss"

export default function Button({ secondary, tertiary, children, to, href, target, onClick, disabled }: Props) {
    const modifier = getTypeModifier(secondary, tertiary)
    const className = `Button ${modifier}`

    if (href) {
        return <a href={href} target={target} className={className}>{children}</a>
    } else if (to) {
        return <Link to={to} className={className}>{children}</Link>
    } else {
        return <button className={className} onClick={onClick} disabled={disabled}>{children}</button>
    }
}

function getTypeModifier(secondary?: boolean, tertiary?: boolean): string {
    if (secondary) return "secondary"
    if (tertiary) return "tertiary"
    return ""
}

interface Props {
    secondary?: boolean
    tertiary?: boolean
    to?: string
    target?: React.AnchorHTMLAttributes<HTMLAnchorElement>["target"]
    href?: React.AnchorHTMLAttributes<HTMLAnchorElement>["href"]
    disabled?: boolean
    onClick?: React.DetailedHTMLProps<React.ButtonHTMLAttributes<HTMLButtonElement>, HTMLButtonElement>["onClick"]
    children: React.ReactNode
}