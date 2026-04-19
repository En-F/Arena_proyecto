import '../../../css/actividad/show.css';

interface Props {
    id: number;
    titulo: string;
    imagen: string;
    descripcion: string;
    nivel: string;
}

export default function ShowActividad({
    id,
    titulo,
    descripcion,
    imagen,
    nivel,
}: Props) {
    return (
        <>
            <div className="hero-content-text">
                <h1 className="hero-title">{titulo}</h1>

                <div className="hero-meta">
                    <span className="meta-item">📊 {nivel}</span>
                </div>

                <p className="hero-description">{descripcion}</p>
            </div>

            <div className="hero-image-container">
                <img
                    src={`/storage/${imagen}`}
                    alt={titulo}
                    className="hero-image"
                />
            </div>
        </>
    );
}
