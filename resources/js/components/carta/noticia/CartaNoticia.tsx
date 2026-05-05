import { Link } from '@inertiajs/react';
import '../../../../css/carta/carta_noticia.css';

interface Props {
    id: number;
    titulo: string;
    imagen: string;
    contenido: string;
    esCrear?: boolean;
    es_activo?: boolean;
}

export default function CartaNoticia({
    id,
    titulo,
    imagen,
    contenido,
    esCrear = false,
    es_activo = true,
}: Props) {
    if (esCrear) {
        return (
            <Link href="/noticias/create" className="centro-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <Link
            key={id}
            href={`/noticias/${id}`}
            className={es_activo ? 'news-card' : 'news-card-inactivo'}
        >
            <div className="news-img-wrapper">
                <img
                    src={`/storage/${imagen}`}
                    alt={titulo}
                    className="news-img"
                />
            </div>
            <h4>{titulo}</h4>
        </Link>
    );
}
