import { usePage, router } from '@inertiajs/react';
import '../../../css/actividad/show.css';
import Button from '../Layouts/Button';
import { route } from 'ziggy-js';
import '../../../css/noticia/show.css';

interface Props {
    id: number;
    nombre: string;
    imagen: string;
    descripcion: string;
    nivel: string;
}

export default function ShowActividad({
    id,
    nombre,
    descripcion,
    imagen,
    nivel,
}: Props) {
    const { auth } = usePage().props;

    const handleBorrarElemento = (id: number) => {
        if (confirm(`¿Estás seguro de que quieres eliminar esta noticia?`)) {
            router.delete(route('actividades.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    return (
        <>
            <div className="hero-content-text">
                <h1 className="hero-title">{nombre}</h1>

                <div className="hero-meta">
                    <span className="meta-item">📊 {nivel}</span>
                </div>

                <p className="hero-description">{descripcion}</p>
                {(auth.user?.is_admin || auth.user?.is_jefe) && (
                    <div className="botones-acciones">
                        <Button
                            href={route('actividades.edit', id)}
                            className="btn btn-info"
                        >
                            Editar
                        </Button>

                        <Button
                            onClick={() => handleBorrarElemento(id)}
                            className="btn btn-error"
                        >
                            Eliminar
                        </Button>
                    </div>
                )}
            </div>

            <div className="hero-image-container">
                <img
                    src={`/storage/${imagen}`}
                    alt={nombre}
                    className="hero-image"
                />
            </div>
        </>
    );
}
