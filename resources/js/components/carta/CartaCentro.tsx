import { Link, router, usePage, } from '@inertiajs/react';
import '../../../css/carta/carta_centro.css';
import Button from '../Layouts/Button';
import '../../../css/button.css';

interface Props {
    id?: number;
    nombre?: string;
    imagen?: string;
    esCrear?: boolean;
}

export default function CartaCentro({
    id,
    nombre,
    imagen,
    esCrear = false,
}: Props) {
    const { auth } = usePage().props;
    
    const handleOcultarCentro = (e: React.MouseEvent) => {
        e.stopPropagation();
        e.preventDefault();

        if(confirm('¿Estás seguro de que quieres ocultar este centro?')) {
            router.post('/centros/ocultar',{id:id},{
                preserveScroll: true,
            })
        }

    }
    
    if (esCrear) {
        return (
            <Link href="/centros/create" className="centro-item">
                <div className="img-card-container carta-crear">
                    <span className="carta-crear-plus">+</span>
                </div>
            </Link>
        );
    }

    return (
            <div style={{ position: 'relative' }}>
            <Link href={`/centros/${id}`} className="centro-item">
                <div className="img-card-container">
                    <img src={`/storage/${imagen}`} alt={nombre} />
                </div>
                <p className="centro-title">{nombre}</p>
            </Link>

            {auth.user?.name === 'Admin' && (
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
