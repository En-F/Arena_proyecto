import '../../../css/carta/banner_inscripcion.css';
import { Link } from '@inertiajs/react';
import Button from '../Layouts/Button';

interface Props {
    imagen: string;
    titulo: string;
    descripcion: string;
    textBoton: string;
    href: string;
}

export default function BannerInscripcion({
    imagen,
    titulo,
    descripcion,
    textBoton,
    href,
}: Props) {
    return (
        <>
            <div className="banner-content">
                <div className="banner-image">
                    <img src={`/storage/otros/${imagen}`} alt="titulo" />
                </div>
                <div className="banner-text-box">
                    <h3>{titulo}</h3>
                    <p>{descripcion}</p>
                    <Button href={href} className="btn-inscripcion">
                        {textBoton}
                    </Button>
                </div>
            </div>
        </>
    );
}
