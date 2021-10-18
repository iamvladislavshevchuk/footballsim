import debounce from "../../../../helpers/debounce"
import useStatic from "../../../../hooks/useStatic"

export default function ScoreInput({ defaultValue, onChange, position }: Props) {
    const handleChange = useStatic(debounce<React.ChangeEventHandler<HTMLInputElement>>((e) => {
        onChange(e.target.value, position)
    }, 600))

    return <input min="0" max="9" type="number" defaultValue={defaultValue} onChange={handleChange} />
}

interface Props {
    defaultValue: number
    onChange: (score: string, position: "home_score" | "away_score") => Promise<void>
    position: "home_score" | "away_score"
}