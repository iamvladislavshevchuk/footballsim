import ScoreInput from "./ScoreInput";

export default function Score({ game, onChange }: Props) {
    const handleChange = async (score: string, position: "home_score" | "away_score") => {
        onChange(score, position, game)
    }

    return (
        <div className="score">
            {game.home_score === null ? "?" : <ScoreInput defaultValue={game.home_score} onChange={handleChange} position="home_score" />}
            <span> : </span>
            {game.away_score === null ? "?" : <ScoreInput defaultValue={game.away_score} onChange={handleChange} position="away_score" />}
        </div>
    )
}

interface Props {
    game: Resources.Game
    onChange: (score: string, position: "home_score" | "away_score", game: Resources.Game) => Promise<void>
}