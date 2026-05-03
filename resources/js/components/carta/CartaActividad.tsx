import { Link, router, usePage } from '@inertiajs/react';
import '../../../css/carta/carta_actividad.css';
import Button from '../Layouts/Button';
import '../../../css/button.css';

interface Props {
    id?: number;
    titulo?: string;
    imagen?: string;
    esCrear?: boolean;
    es_activo?: boolean;
}

export default function CartaActividad({
    id,
    titulo,
    imagen,
    esCrear = false,
    es_activo = true,
}: Props) {
    const { auth } = usePage().props;

    const handleOcultarElemento = (e: React.MouseEvent) => {
        e.stopPropagation();
        e.preventDefault();

        const accion = es_activo ? 'ocultar' : 'mostrar';
        if (confirm(`¿Estás seguro de que quieres ${accion} esta actividad?`)) {
            router.post(
                '/actividades/ocultar',
                { id: id },
                { preserveScroll: true },
            );
        }
    };

    if (esCrear) {
        return (
            <Link href="/actividades/create" className="centro-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
        <div>
            <Link
                key={id}
                href={`/actividades/${id}`}
                className="activity-card"
                style={{
                    position: 'relative',
                    opacity: es_activo ? 1 : 0.5,
                }}
            >
                <div className="activity-img-wrapper">
                    <img
                        src={`/storage/${imagen}`}
                        alt={titulo}
                        className="activity-img"
                    />
                    <div className="activity-overlay">
                        <span className="activity-explore">Explorar</span>
                    </div>
                </div>
                <p className="activity-title">{titulo}</p>
            </Link>
            {auth.user && (auth.user.is_admin || auth.user.is_jefe) && (
                <div>
                    <Button
                        type="button"
                        onClick={handleOcultarElemento}
                        className={` ${es_activo ? 'btn mt-5 btn-soft btn-error' : 'btn mt-5 btn-soft btn-info'}`}
                    >
                        {es_activo ? 'Ocultar' : 'Mostrar'}
                    </Button>
                </div>
            )}
        </div>
    );
}
