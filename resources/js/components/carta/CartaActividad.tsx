import { Link, router, usePage } from '@inertiajs/react';
import '../../../css/carta/carta_actividad.css';
import Button from '../Layouts/Button';
import '../../../css/button.css';


interface Props {
    id?: number;
    titulo?: string;
    imagen?: string;
    esCrear?: boolean;
}

export default function CartaActividad({
    id,
    titulo,
    imagen,
    esCrear = false,
}: Props) {

    const { auth } = usePage().props;
    

    const handleOcultarCentro = (e: React.MouseEvent) => {
            e.stopPropagation();
            e.preventDefault();
    
            if(confirm('¿Estás seguro de que quieres ocultar esta actividad?')) {
                router.post('/actividades/ocultar',{id:id},{
                    preserveScroll: true,
                })
            }
    
        }

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
        <div style={{ position: 'relative' }}>
        <Link key={id} href={`/actividades/${id}`} className="activity-card">
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
            <div className="admin-controls">
                <Button
                    type="button"
                    onClick={handleOcultarCentro}
                    className="btn-crud ocultar"
                >
                    Ocultar
                </Button>
            </div>
        )}
        </div>
    );
}
