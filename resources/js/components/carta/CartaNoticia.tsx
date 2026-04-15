import { Link } from '@inertiajs/react';
import '../../../css/carta/carta_noticia.css';

interface Props {
    id: number;
    titulo: string;
    imagen: string;
    contenido: string;
}

export default function CartaNoticia({ id, titulo, imagen, contenido }: Props) {
    return (
        <Link key={id} href={`/noticias/${id}`} className="news-card">
            <div className="news-img-wrapper">
                <img
                    src={`/storage/${imagen}`}
                    alt={titulo}
                    className="news-img"
                />
            </div>
            <h4>{titulo}</h4>
            <p>{contenido || 'Haz clic para leer más sobre esta noticia...'}</p>
        </Link>
    );
}
